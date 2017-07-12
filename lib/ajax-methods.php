<?php

require_once 'mkmapi.php';

use Roots\Sage\Utils;
use Roots\Sage\CurrencyCalculator;

function mkm_add_card() {

  $date1 = new DateTime();

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $list = $_POST['list'];

  $list = explode("\r\n", $list);

  // Break script if more than 15 cards are included at one time
  if ( count($list) > 15 ) {

    $return_data['success'] = 0;
    $return_data['error_msg'] = "Wczytałeś więcej niż 15 kart";

    die( json_encode($return_data) );

  }

  $card_data = array ();

  foreach ($list as $index => $item) {
    $list[$index] = explode("\t", $item);
    $card_data[$index]['name'] = $list[$index][0];
    $card_data[$index]['expansion'] = $list[$index][1];
    $card_data[$index]['price'] = $list[$index][2];
    $card_data[$index]['condition'] = $list[$index][4] ? $list[$index][4] : "nm";
    $card_data[$index]['lang'] = $list[$index][5] ? $list[$index][5] : "eng";
    $card_data[$index]['info'] = $list[$index][6];
    $card_data[$index]['quant'] = $list[$index][7] ? $list[$index][7] : 1;

    // Break if there is no card name
    if ( !$card_data[$index]['name'] ) {

      $return_data['success'] = 0;
      $return_data['error_msg'] = "Nie podałeś nazwy karty";

      die( json_encode($return_data) );

    }

    // Setup data for new post
    $postarr = array (
      'post_title'  => $list[$index][0],
      'post_status' => 'publish',
      );

    $last_post_id = get_last_post_id() ? get_last_post_id() : null;

    if ( get_the_title($last_post_id) != $card_data[$index]['name'] ||
      get_post_meta($last_post_id, 'edycja')[0] != $card_data[$index]['expansion'] ||
      get_post_meta($last_post_id, 'stan')[0] != $card_data[$index]['condition'] ||
      get_post_meta($last_post_id, 'jezyk')[0] != $card_data[$index]['lang'] ) {

      $return_data['dane_wejsciowe'] = array (
        get_post_meta($last_post_id, 'edycja')[0],
        $card_data[$index]['expansion'],
        get_post_meta($last_post_id, 'stan')[0],
        $card_data[$index]['condition'],
        get_post_meta($last_post_id, 'jezyk')[0],
        $card_data[$index]['lang']
        );

    wp_insert_post( $postarr );

    $added_post_id = get_last_post_id() ? get_last_post_id() : null;

      // check if card is foil and modify expansion name if is
    $is_foil = strpos($card_data[$index]['expansion'], 'Foil') ? strpos($card_data[$index]['expansion'], 'Foil') : null;
    if ( $is_foil ) {
      $card_data[$index]['expansion'] = substr($card_data[$index]['expansion'], 0, -(strlen($card_data[$index]['expansion']) - $is_foil + 1) );
      update_field('foil', 1, $added_post_id);
    }

    update_field('edycja', $card_data[$index]['expansion'], $added_post_id);
    update_field('stan', $card_data[$index]['condition'], $added_post_id);
    // if ( $card_data[$index]['discount'] ) {
    //  update_field('discount', $card_data[$index]['discount'], $added_post_id);
    // } else
    if ( $card_data[$index]['condition'] != 'nm' ) {

      switch ($card_data[$index]['condition']) {

        case 'lp':
        update_field('discount', get_field("Discount_lp", "options"), $added_post_id);
        break;

        case 'mp':
        update_field('discount', get_field("Discount_mp", "options"), $added_post_id);
        break;

        case 'hp':
        update_field('discount', get_field("Discount_hp", "options"), $added_post_id);
        break;

        default:
        break;

      }

    }
    update_field('jezyk', $card_data[$index]['lang'], $added_post_id);
    update_field('uwagi', $card_data[$index]['info'], $added_post_id);
    update_field('ilosc', $card_data[$index]['quant'], $added_post_id);

    $return_data['mkm_response'] = MKM_update_price( $added_post_id, $is_foil );
    $return_data['success'] = 1;

  } else {
    $return_data['success'] = 0;
    $return_data['error_msg'] = "Prawdopodobnie drugi raz dodajesz tą samą kartę";

      // remove previously added post
    // if ( $added_post_id ) wp_delete_post($added_post_id);

    die( json_encode($return_data) );
  }
}

$date2 = new DateTime();
$diff = $date2->diff($date1);

$return_data['duration'] = "Wczytanie kart trwało " . $diff->format('%i minut i %s sekund');

die( json_encode($return_data) );

}

function get_last_post_id($post_type = "post") {

  $last = wp_get_recent_posts(array (
    "numberposts" => 1,
    "post_type"   => $post_type
    ));

  if ( !empty($last) ) {
    return $last['0']['ID'];
  } else {
    return;
  }

}

add_action( 'wp_ajax_add_card', 'mkm_add_card' );
add_action( 'wp_ajax_nopriv_add_card', 'mkm_add_card' );

function mkm_trash_post() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];

  wp_trash_post($post_id);

  $return_data["success"] = 1;
  $return_data["post"] = $_POST;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_trash_post', 'mkm_trash_post' );
add_action( 'wp_ajax_nopriv_trash_post', 'mkm_trash_post' );

function mkm_freeze_post() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];

  $is_frozen = get_post_meta( $post_id, "price_frozen" );
  $new_state = $is_frozen[0] ? 0 : 1;

  update_post_meta( $post_id, "price_frozen", $new_state, $is_frozen[0] );

  $return_data["czy_byla_zamrozona"] = $is_frozen[0];
  $return_data["czy_jest_zamrozona"] = get_post_meta( $post_id, "price_frozen" );

  $return_data["success"] = 1;
  $return_data["post"] = $_POST;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_freeze_post', 'mkm_freeze_post' );
add_action( 'wp_ajax_nopriv_freeze_post', 'mkm_freeze_post' );

function mkm_info_cards() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $is_foil = $_POST["is_foil"];

  $mkm_response = MKM_API($post_id, $is_foil);

  $return_data["success"] = 1;
  $return_data["MKM_response"] = $mkm_response;

  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_info_cards', 'mkm_info_cards' );
add_action( 'wp_ajax_nopriv_info_cards', 'mkm_info_cards' );

function mkm_update_post() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $is_foil = $_POST["is_foil"];

  $mkm_response = MKM_update_price($post_id, $is_foil);

  $return_data["success"] = 1;
  $price = $mkm_response;
  $discount = get_post_meta( $post_id, "discount");
  $return_data["price"] = array_key_exists( 0, $discount ) ? CurrencyCalculator\fmtMoney( $price * ( 1 - $discount[0] ) ) : $price;

  $prev_price = get_post_meta($post_id, 'cena')[0];

  if ( $mkm_response !== 0 && $mkm_response !== $prev_price ) {

    update_post_meta( $post_id, "cena", $mkm_response, $prev_price );

  }

  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_post', 'mkm_update_post' );
add_action( 'wp_ajax_nopriv_update_post', 'mkm_update_post' );

function mkm_update_cron_posts() {

  $start_date = new dateTime();

  $new_cron_step = update_cards_prices();

  $return_data["updated_prices"] = $new_cron_step;

  $finish_date = new dateTime();

  $interval = date_diff( $start_date, $finish_date );

  $return_data["rozpoczecie_skryptu"] = $start_date->format("d-m-Y H:i:s");
  $return_data["skończenie_skryptu"] = $finish_date->format("d-m-Y H:i:s");
  $return_data["trwanie_skryptu"] = $interval->format("%h[g]:%i[m]:%s[s]");

  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_cron_posts', 'mkm_update_cron_posts' );
add_action( 'wp_ajax_nopriv_update_cron_posts', 'mkm_update_cron_posts' );

function mkm_update_quantity() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $type = $_POST["type"];
  // $prev_quantity = (int)get_post_meta($post_id, $type)[0];
  $prev_quantity = $_POST["previous"];
  $quantity =  $prev_quantity + $_POST["value"];

  // $mkm_response = MKM_API($post_id, $is_foil);

  if ( $quantity === 0 && $type === "ilosc" ) {

    wp_trash_post($post_id);

  } else if ( $quantity < 0 ) {

    $quantity = 0;

  } else if ( $type === "ilosc" ) {

    update_post_meta( $post_id, $type, $quantity );

  } else if ( $type === "sprzedane" ) {

    update_post_meta( $post_id, $type, $quantity );
    $ilosc = get_post_meta( $post_id, "ilosc" )[0];
    update_post_meta( $post_id, "ilosc", $ilosc - $_POST["value"] );

  }

  $return_data["success"] = 1;
  $return_data["prev_quantity"] = (int)$prev_quantity;
  $return_data["quantity"] = $quantity;
  $return_data["type"] = $type;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_quantity', 'mkm_update_quantity' );
add_action( 'wp_ajax_nopriv_update_quantity', 'mkm_update_quantity' );

function mkm_update_forum() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  if ( $new_content = $_POST["forum_content"] ) {

    update_field( "forum_content", $new_content, "options");

  }

  $return_data["success"] = 1;
  $return_data["value"] = "Pomyślnie zaktualizowano treści";
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_forum', 'mkm_update_forum' );
add_action( 'wp_ajax_nopriv_update_forum', 'mkm_update_forum' );

function mkm_choose_condition() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $return_data["success"] = 1;
  $return_data["value"] = Utils\get_conditions_array ();
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_choose_condition', 'mkm_choose_condition' );
add_action( 'wp_ajax_nopriv_choose_condition', 'mkm_choose_condition' );

function mkm_update_condition() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $condition =  $_POST["value"];

  if ( $condition ) {

    update_post_meta( $post_id, "stan", $condition );

  }

  $return_data["success"] = 1;
  $return_data["value"] = $condition;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_condition', 'mkm_update_condition' );
add_action( 'wp_ajax_nopriv_update_condition', 'mkm_update_condition' );

function mkm_choose_language() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $return_data["success"] = 1;
  $return_data["value"] = Utils\get_languages_array ();
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_choose_language', 'mkm_choose_language' );
add_action( 'wp_ajax_nopriv_choose_language', 'mkm_choose_language' );

function mkm_update_language() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $language =  $_POST["value"];

  if ( $language ) {

    update_post_meta( $post_id, "jezyk", $language );

  }

  $return_data["success"] = 1;
  $return_data["value"] = $language;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_language', 'mkm_update_language' );
add_action( 'wp_ajax_nopriv_update_language', 'mkm_update_language' );

function mkm_choose_owner() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $return_data["success"] = 1;
  $return_data["value"] = Utils\get_owners_array ();
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_choose_owner', 'mkm_choose_owner' );
add_action( 'wp_ajax_nopriv_choose_owner', 'mkm_choose_owner' );

function mkm_update_owner() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $owner =  $_POST["value"];

  if ( $owner ) {

    update_post_meta( $post_id, "własność", $owner );

  }

  $return_data["success"] = 1;
  $return_data["value"] = $owner;
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_owner', 'mkm_update_owner' );
add_action( 'wp_ajax_nopriv_update_owner', 'mkm_update_owner' );

function mkm_sell_cards() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $post_id = $_POST["post_id"];
  $amount =  $_POST["amount"];

  if ( $amount > 0 ) {
    $available = get_post_meta($post_id, "ilosc")[0];
    $already_sold = get_post_meta($post_id, "sprzedane")[0];
    if ( $amount > $available ) {
      $return_data["success"] = 0;
      $return_data["message"] = __("You're trying to sell more cards than you have available");
      die( json_encode( $return_data ) );
    } else if ( $amount !== $already_sold ) {
      update_post_meta( $post_id, "ilosc", $available - ( $amount - $already_sold ) );
      update_post_meta( $post_id, "sprzedane", $amount );
      $return_data["success"] = 1;
      $return_data["ilosc"] = $available - ( $amount - $already_sold );
      $return_data["sprzedane wczesniej"] = $already_sold;
      $return_data["sprzedane w tej transakcji"] = $amount - $already_sold;
      die( json_encode( $return_data ) );
    } else {
      $return_data["success"] = 0;
      $return_data["message"] = __("Please change amount of sold cards first");
      die( json_encode( $return_data ) );
    }
  }

  $return_data["success"] = 0;
  $return_data["message"] = __("You're trying to sell zero cards");
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_sell_cards', 'mkm_sell_cards' );
add_action( 'wp_ajax_nopriv_sell_cards', 'mkm_sell_cards' );

function mkm_load_posts() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $rarity = $_POST["rarity"];
  $paged = $_POST["paged"];
  $order = !empty($_POST["order"]) ? $_POST["order"] : "ASC";
  $orderby =  !empty($_POST["orderby"]) ? $_POST["orderby"] : "title";
  $meta_key =  !empty($_POST["meta_key"]) ? $_POST["meta_key"] : NULL;

  $args = array (
    'post_type' => array ( 'post' ),
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged + 1,
    'order' => $order,
    'orderby' => $orderby,
    'meta_query' => array (
     array (
      'key' => 'rarity',
      'value' => $rarity + 1,
      'compare' => '=',
      ),
     ),
    'cache_results' => true,
    'update_post_meta_cache' => true,
    'update_post_term_cache' => true,
    );

  if ($meta_key) { $args['meta_key'] = $meta_key; }

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
     $query->the_post();
     get_template_part('templates/content');
   }

   wp_reset_postdata();
   die();

 } else {

  $return_data["success"] = 0;
  $return_data["message"] = __("You've reached end of internet");
  die( json_encode( $return_data ) );

}

}

add_action( 'wp_ajax_load_posts', 'mkm_load_posts' );
add_action( 'wp_ajax_nopriv_load_posts', 'mkm_load_posts' );

function mkm_update_form_expansions() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $return_data["success"] = 1;
  $return_data["name"] = $_POST["name"];
  $return_data["MKM_response"] = MKM_API(str_replace("\\", "", $_POST["name"]));
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_update_form_expansions', 'mkm_update_form_expansions' );
add_action( 'wp_ajax_nopriv_update_form_expansions', 'mkm_update_form_expansions' );

function mkm_add_single_card() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $postarr = array (
    'post_title'  => $_POST["name"],
    'post_status' => 'publish',
    );

  $last_post_id = get_last_post_id() ? get_last_post_id() : null;

  if ( $last_post_id) {
    wp_insert_post( $postarr );
    $added_post_id = get_last_post_id() ? get_last_post_id() : null;
  }

  if ( $added_post_id ) {
    $expansion = $_POST["expansion"];
    update_field( "edycja", $expansion, $added_post_id);

    $condition = $_POST["condition"];
    update_field( "stan", $condition, $added_post_id);

    if ( $condition != 'nm' ) {

      switch ($condition) {

        case 'lp':
        update_field('discount', get_field("Discount_lp", "options"), $added_post_id);
        break;

        case 'mp':
        update_field('discount', get_field("Discount_mp", "options"), $added_post_id);
        break;

        case 'hp':
        update_field('discount', get_field("Discount_hp", "options"), $added_post_id);
        break;

        default:
        break;

      }

    }

    $language = $_POST["language"];
    update_field( "jezyk", $language, $added_post_id);

    $quantity = $_POST["quantity"];
    update_field( "ilosc", $quantity, $added_post_id);

    $comments = $_POST["comments"];
    update_field( "uwagi", $comments, $added_post_id);

    $is_foil = $_POST["foil"];
    if ( $is_foil ) { update_field( "foil", $is_foil, $added_post_id); }

    $owner = $_POST["owner"];
    update_field( "własność", $owner, $added_post_id);

    update_field( "sprzedane", 0, $added_post_id);

    $price = $_POST["product_id"] ? MKM_update_card( $added_post_id, $is_foil, $_POST["product_id"]) : MKM_update_price( $added_post_id, $is_foil );
    // $return_data["MKM_product_response"] = MKM_update_price( $added_post_id, $is_foil, $_POST["product_id"]);

    $return_data["MKM_updated_price"] = $price;
  }
  // $return_data["mkm_id"] = $_POST["product_id"];
  $return_data["success"] = 1;
  $return_data["name"] = $_POST["name"];
  $return_data["message"] = __("Succesfully added") . " " . $_POST["name"];
  // if ( $price ) { $return_data["message"] .= " " . __("with price") . " $price zł"; }
  die( json_encode( $return_data ) );

}

add_action( 'wp_ajax_add_single_card', 'mkm_add_single_card' );
add_action( 'wp_ajax_nopriv_add_single_card', 'mkm_add_single_card' );

// function mkm_load_searched_card() {

//  if ( !isset( $_POST ) || empty( $_POST ) ) {
//    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
//    die( json_encode( $return_data ) );
//  }

//  // print_r($_POST);

//  // echo $_POST["card-id"];

//  $args = array (
//    'post_type'   => array ( 'post' ),
//    'p'       => $_POST["card-id"]
//    );

//  $query = new WP_Query( $args );

//  if ( $query->have_posts() ) {
//    while ( $query->have_posts() ) {
//      $query->the_post();
//      get_template_part('templates/content-search');
//    }

//    wp_reset_postdata();
//    die();

//  } else {

//    $return_data["success"] = 0;
//    $return_data["message"] = __("You've reached end of internet");
//    die( json_encode( $return_data ) );

//  }

// }

// add_action( 'wp_ajax_load_searched_card', 'mkm_load_searched_card' );
// add_action( 'wp_ajax_nopriv_load_searched_card', 'mkm_load_searched_card' );

function mkm_add_to_basket() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
    die( json_encode( $return_data ) );
  }

  $args = array (
    'post_type'   => array ( 'post' ),
    'p'       => $_POST["card-id"]
    );

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      get_template_part('templates/content-basket-row');
    }

    wp_reset_postdata();
    die();

  } else {

    $return_data["success"] = 0;
    $return_data["message"] = __("You've reached end of internet");
    die( json_encode( $return_data ) );

  }

}

add_action( 'wp_ajax_add_to_basket', 'mkm_add_to_basket' );
add_action( 'wp_ajax_nopriv_add_to_basket', 'mkm_add_to_basket' );


function mkm_add_basket() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    if (isset($_POST['basket_id'])) { $basket_id = $_POST['basket_id']; }
    $basket_name = $_POST['basket_name'];
    $discount = $_POST['discount'];
    $shipping_cost = $_POST['shipping_cost'];
    $team_sum = $_POST['team_sum'];
    $leszek_sum = $_POST['leszek_sum'];
    $slawek_sum = $_POST['slawek_sum'];
    $total_sum = $_POST['total_sum'];
    $cards = $_POST['cards'];
    $basket_status = $_POST['basket_status'];

    if (!isset($basket_id)) {
      $postarr = array (
        'post_type'   => 'basket',
        'post_title'  => current_time('Y-m-d') . "-" . $basket_name,
        'post_status' => 'publish',
        );

      wp_insert_post( $postarr );

      $added_post_id = get_last_post_id('basket') ? get_last_post_id('basket') : null;
    } else {
      $added_post_id = $basket_id;
    }

    update_post_meta($added_post_id, 'basket_discount', $discount);
    update_post_meta($added_post_id, 'basket_shipping_cost', $shipping_cost);
    update_post_meta($added_post_id, 'basket_team_sum', $team_sum);
    update_post_meta($added_post_id, 'basket_leszek_sum', $leszek_sum);
    update_post_meta($added_post_id, 'basket_slawek_sum', $slawek_sum);
    update_post_meta($added_post_id, 'basket_total_sum', $total_sum);
    update_post_meta($added_post_id, 'basket_status', $basket_status);

    $cards_array = array ();
    $return_data = array ();

    foreach ( $cards as $key => $card ) {

      $cards_array[] = array (
        'card_name'   => $card['cardId'],
        'card_price'  => $card['price'],
        'card_amount' => $card['amount']
        );

      // update amount of reserved cards
      $cards_reserved = get_post_meta($card['cardId'], "cards_reserved");
      if (!$cards_reserved[0]) { $cards_reserved = 0; }

      if (!isset($basket_id)) {
        update_post_meta($card['cardId'], "cards_reserved", $cards_reserved[0] + $card['amount']);

        // update_field('field_5964d04c485d3', $cards_reserved[0] + $card['amount']);

      // update amount of available cards
        $cards_available = get_field('field_56606fee5ca20', $card['cardId']);
      // echo $cards_available;
        update_field('field_56606fee5ca20', $cards_available - $card['amount'], $card['cardId']);

      }

      // dodaj informację o ilości kart dostępnych i zarezerwowanych do tablicy danych zwrotnych
      $return_data["cards"][$card['cardId']]["cards_reserved"] = get_post_meta($card['cardId'], "cards_reserved");
      $return_data["cards"][$card['cardId']]["cards_ilosc"] = get_field('field_56606fee5ca20', $card['cardId']);
    }

    update_field('field_5964d130e216d', $cards_array, $added_post_id);

    $return_data['added_post_id'] = $added_post_id;
    $return_data['discount'] = $discount;
    $return_data['total_sum'] = $total_sum;
    $return_data['basket_status'] = $basket_status;
    $return_data['value'] = __('Success', 'sage');

    die( json_encode( $return_data ) );

  }

}

add_action( 'wp_ajax_add_basket', 'mkm_add_basket' );
add_action( 'wp_ajax_nopriv_add_basket', 'mkm_add_basket' );

function mkm_load_basket() {

  // $return_data['test'] = "dzialam";

  // die(json_encode($return_data));

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    $id = $_POST["basket_id"];
    $cards = get_field( 'field_5964d130e216d', $id );

    // $return_data["POST"]["id"] = $id;
    // $return_data["is_ready"] = function_exists( "have_rows" ) ? "1" : "0";
    // $return_data["basket_content"]["cards"] = $cards;

    if ( have_rows('field_5964d130e216d', $id) ) {
      while ( have_rows('field_5964d130e216d', $id) ) {
        the_row();
        // $return_data['cards'][] = get_sub_field('card_price');
        $card = get_sub_field('card_name');
        $price = get_sub_field('card_price');
        $amount_sold = get_sub_field('card_amount');
        $args = array (
          'post_type'   => array ( 'post' ),
          'p'       => $card->ID
          );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
            global $post;
            include locate_template('templates/content-basket-row.php');
          }

          wp_reset_postdata();

        }
      }

      die(json_encode($args));
    } else {

      $return_data["message"] = "No rows for this basket";

      die(json_encode($return_data));

    }
  }

}

add_action( 'wp_ajax_load_basket', 'mkm_load_basket' );
add_action( 'wp_ajax_nopriv_load_basket', 'mkm_load_basket' );

function get_basket_discount() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    $id = $_POST["basket_id"];
    $return_data = array (
      "discount"  => get_post_meta($id, 'basket_discount', true),
      "shipping"  => get_post_meta($id, 'basket_shipping_cost', true),
      "status"  => get_post_meta($id, 'basket_status', true),
      );

    die( json_encode( $return_data ) );
  }

}

add_action( 'wp_ajax_get_basket_discount', 'get_basket_discount' );
add_action( 'wp_ajax_nopriv_get_basket_discount', 'get_basket_discount' );

/**********************************************************************
*                                                                     *
*       UPDATE BASKET STATUS                                          *
*                                                                     *
**********************************************************************/

function update_basket_status() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    $id = $_POST["basket_id"];
    $status = $_POST["status"];

    $current_status = get_post_meta( $id, "basket_status", true );

    $return_data = array (
      "dane_wejsciowe"  => array (
        "id"                => $id,
        "zmien_status"      => $status,
        "aktualny_status"   => $current_status,
        )
      );

    if ( $status !== $current_status ) {

      update_post_meta( $id, "basket_status", $status );
      
      // store return value as variable
      $cards_update = update_cards_amounts( $id, $status, $current_status );

      update_summaries( $id, $status, $current_status );

      $return_data["value"] = sprintf( __('Cart nr %s status changed to %s', 'sage'), $id, $status );

    } else {

      $cards_update = array (
        "Nic nie zostało zaktualizowane"
        );

      $return_data["value"] = __('You haven\'t changed cart status.', 'sage');

    }

    // $return_data = array_merge( $return_data, $cards_update );
    $return_data["updated_cards"] = $cards_update;

    die( json_encode( $return_data ) );
  }

}

add_action( 'wp_ajax_update_basket_status', 'update_basket_status' );
add_action( 'wp_ajax_nopriv_update_basket_status', 'update_basket_status' );

/**********************************************************************
*                                                                     *
*       GET BASKET STATUS                                             *
*                                                                     *
**********************************************************************/

function get_basket_status() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    $id = $_POST["basket_id"];

    $status = get_post_meta( $id, "basket_status", true );
    $status_string = null;

    switch ($status) {
      case 'shipped':
      $status_string = __("Shipped", "sage");
      break;

      case 'billed':
      $status_string = __("Billed", "sage");
      break;
      
      default:
      $status_string = __("Pre order", "sage");
      break;
    }

    $return_data = array (
      "status"        => $status,
      "statusString"  => $status_string,
      );

    die( json_encode( $return_data ) );
  }

}

add_action( 'wp_ajax_get_basket_status', 'get_basket_status' );
add_action( 'wp_ajax_nopriv_get_basket_status', 'get_basket_status' );

/**********************************************************************
*                                                                     *
*       REMOVE BASKET                                                 *
*                                                                     *
**********************************************************************/

function remove_basket() {

  if ( !isset( $_POST ) || empty( $_POST ) ) {
    $return_data['value'] = __( 'Error', 'sage' );
    die( json_encode( $return_data ) );
  } else {

    $id = $_POST["basket_id"];

    update_cards_amounts( $id, "trash" );
    $response = wp_trash_post( $id );

    $return_data = array (
      "value"        => __("Succesfully deleted post.", "sage"),
      );

    die( json_encode( $return_data ) );
  }

}

add_action( 'wp_ajax_remove_basket', 'remove_basket' );
add_action( 'wp_ajax_nopriv_remove_basket', 'remove_basket' );

function update_cards_amounts($basket_id, $basket_status, $basket_previous_status) {

  // check if the repeater field has rows of data
  if( have_rows("field_5964d130e216d", $basket_id) ) {

    $karty_w_koszyku = get_field("field_5964d130e216d", $basket_id);

    $return_data = array (
      "kart_w_koszyku" => count($karty_w_koszyku)
      );

  // loop through the rows of data
    while ( have_rows("field_5964d130e216d", $basket_id) ) {
      the_row();

      // display a sub field value
      $card_name = get_sub_field('card_name');
      $card_amount = get_sub_field('card_amount');
      $available_cards = get_post_meta( $card_name->ID, "ilosc", true );
      $reserved_cards = get_post_meta( $card_name->ID, "cards_reserved", true );
      $sold_cards = get_post_meta( $card_name->ID, "sprzedane", true );

      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wejsciu"]["nazwa_karty"] = $card_name->post_name;
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wejsciu"]["ilosc_w_koszyku"] = $card_amount;
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wejsciu"]["ilosc_w_sklepie"] = $available_cards;
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wejsciu"]["sprzedane"] = $get_post_meta;
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wejsciu"]["zarezerwowane"] = $reserved_cards;

      switch ($basket_status) {
        case 'preorder':
        // add reserved and remove sold if changed from shipped to preorder
        if ($basket_previous_status === "shipped") {
          // zaktualizuj ilość kart zarezerwowanych
          update_post_meta( $card_name->ID, "cards_reserved", $reserved_cards + $card_amount, $reserved_cards );
          // zaktualizuj ilość kart sprzedanych
          update_post_meta( $card_name->ID, "sprzedane", $sold_cards - $card_amount, $sold_cards );
        }
        // add reserved if changed directly from billed to preorder
        else if ($basket_previous_status === "billed") {
          // zaktualizuj ilość kart zarezerwowanych
          update_post_meta( $card_name->ID, "cards_reserved", $reserved_cards + $card_amount, $reserved_cards );      
        }

        break;

        case 'shipped':
        // remove reserved and add sold if changed from preorder to shipped
        if ($basket_previous_status === "preorder") {
          // zaktualizuj ilość kart zarezerwowanych
          update_post_meta( $card_name->ID, "cards_reserved", $reserved_cards - $card_amount, $reserved_cards );
          // zaktualizuj ilość kart dostępnych
          update_post_meta( $card_name->ID, "ilosc", $available_cards - $card_amount, $available_cards );
          // zaktualizuj ilość kart sprzedanych
          update_post_meta( $card_name->ID, "sprzedane", $sold_cards + $card_amount, $sold_cards );
        }
        // add sold if changed from billed to shipped
        // else if ($basket_previous_status === "billed") {
        //   update_post_meta( $card_name->ID, "sprzedane", $sold_cards + $card_amount, $sold_cards );          
        // }

        break;

        case 'billed':
        // remove reserved if changed from preorder directly to billed
        if ($basket_previous_status === "preorder") {
          update_post_meta( $card_name->ID, "cards_reserved", $reserved_cards - $card_amount, $reserved_cards );
        }
        // remove sold if changed from shipped to billed
        else if ($basket_previous_status === "shipped") {
          // zaktualizuj ilość kart sprzedanych o te, które właśnie zostały rozliczone
          update_post_meta( $card_name->ID, "sprzedane", $sold_cards - $card_amount, $sold_cards );
        }

        break;

        case 'trash':
        // add quantity and remove reserved
        update_post_meta( $card_name->ID, "cards_reserved", $reserved_cards - $card_amount, $reserved_cards );   
        update_post_meta( $card_name->ID, "ilosc", $available_cards + $card_amount, $available_cards );         

        break;
        
        default:
          # code...
        break;
      }

      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wyjsciu"]["ilosc_w_sklepie"] = get_post_meta( $card_name->ID, "ilosc", true );
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wyjsciu"]["sprzedane"] = get_field("field_56825fd051b67", $card_name->ID);
      $return_data["basket-" . $basket_id][$card_name->ID]["dane_na_wyjsciu"]["zarezerwowane"] = get_field("field_5964d04c485d3", $card_name->ID);

    }

    return $return_data;

  }

}

function update_summaries($basket_id, $basket_status, $basket_previous_status) {

  $money = array (
    "team"          => get_post_meta( $basket_id, "basket_team_sum", true ),
    "leszek"        => get_post_meta( $basket_id, "basket_leszek_sum", true ),
    "slawek"        => get_post_meta( $basket_id, "basket_slawek_sum", true ),
    "total"         => get_post_meta( $basket_id, "basket_total_sum", true ),
    );

  $totals = array (
    "team"          => get_field("field_5964d0ad4c4d6", "options"),
    "leszek"        => get_field("field_5964d0bd4c4d7", "options"),
    "slawek"        => get_field("field_5964d0cd4c4d8", "options"),
    "total"         => get_field("field_5964d09b4c4d5", "options"),
    );

  if ( $basket_previous_status = "preorder" && $basket_status === "shipped" ) {

    update_field("field_5964d0ad4c4d6", $totals["team"] + $money["team"], "options");
    update_field("field_5964d0bd4c4d7", $totals["leszek"] + $money["leszek"], "options");
    update_field("field_5964d0cd4c4d8", $totals["slawek"] + $money["slawek"], "options");
    update_field("field_5964d09b4c4d5", $totals["total"] + $money["shipping"] + $money["leszek"] + $money["team"] + $money["slawek"], "options");

  }
  else if ( $basket_previous_status = "shipped" && $basket_status === "billed" ) {

    update_field("field_5964d0ad4c4d6", $totals["team"] - $money["team"], "options");
    update_field("field_5964d0bd4c4d7", $totals["leszek"] - $money["leszek"], "options");
    update_field("field_5964d0cd4c4d8", $totals["slawek"] - $money["slawek"], "options");
    update_field("field_5964d09b4c4d5", $totals["total"] - $money["shipping"] - $money["leszek"] - $money["team"] - $money["slawek"], "options");

  }
}
?>
