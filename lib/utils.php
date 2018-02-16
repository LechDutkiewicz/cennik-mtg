<?php

namespace Roots\Sage\Utils;

use Roots\Sage\CurrencyCalculator;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function get_search_form() {
	$form = '';
	locate_template('/templates/searchform.php', true, false);
	return $form;
}
add_filter('get_search_form', __NAMESPACE__ . '\\get_search_form');

function get_rarities() {

	$output = array(
		"Mythic",
		"Rare",
		"Uncommon",
		"Common",
		"Inne",
		"Land",
	);

	return $output;
}

function get_meta_headers() {

	if (is_user_logged_in()) {

		$meta_headers = array(
			"Edycja"	=> "1",
			"Cena"		=> "1",
			"Stan"		=> "1",
			"Ilość"		=> "0",
			"Sprzedane"	=> "1",
			"Język"		=> "1",
			"Discount"	=> "0",
			"Własność"	=> "0"
		);

	} else {

		$meta_headers = array(
			"Edycja"	=> "1",
			"Cena"		=> "1",
			"Stan"		=> "1",
			"Ilość"		=> "0",
			"Język"		=> "1",
		);

	}

	return $meta_headers;
}

function get_meta_array() {

	global $post;

	if ( $post ) {

		$discount = get_post_meta($post->ID, "discount");
		if ( is_array($discount) && array_key_exists(0, $discount) ) {
			$discount = $discount[0];
		} else {
			$discount = 0;
		}

		// setup variables
		$edycja = get_post_meta($post->ID, "edycja");
		$cena = get_post_meta($post->ID, "cena");
		$stan = get_post_meta($post->ID, "stan");
		$ilosc = get_post_meta($post->ID, "ilosc");
		$reserved = get_post_meta($post->ID, "cards_reserved");
		$sprzedane = get_post_meta($post->ID, "sprzedane");
		$jezyk = get_post_meta($post->ID, "jezyk");
		$wlasnosc = get_post_meta($post->ID, "własność");

		$output = array();

		/* Setup edycja */
		
		if ( $edycja ) {
			$output["Edycja"] = "<small>" . $edycja[0] . "</small>";
		} else {
			$output["Edycja"] = "<small>" . __("Undefined") . "</small>";
		}

		/* Setup cena */
		
		if ( $cena ) {
			if ( is_array($cena[0]) && array_key_exists("price_pln", $cena[0]) ) {
				$output["Cena"] = $cena[0]["price_pln"];
			} else {
				$output["Cena"] = $cena[0];
			}
		} else {
			$output["Cena"] = __("Undefined");
		}

		/* Setup stan */
		
		if ( $stan ) {
			$output["Stan"] = $stan[0];
		} else {
			$output["Stan"] = __("Undefined");
		}

		/* Setup ilość */
		
		if ( $ilosc ) {
			$output["Ilość"] = $ilosc[0];
		} else {
			$output["Ilość"] = __("Undefined");
		}

		// if ( $reserved && is_user_logged_in() ) { $output["reserved"] = "<small>" . $reserved[0] . "</small>"; } else { update_field('cards_reserved', 0); $output["reserved"] = "<small>" . 0 . "</small>"; }
		// if ( $sprzedane && is_user_logged_in() ) { $output["Sprzedane"] = $sprzedane[0]; } else { $output["Sprzedane"] = __("Undefined"); }
		if ( $jezyk ) { $output["Język"] = $jezyk[0]; } else { $output["Język"] = __("Undefined"); }
		// if ( $discount && is_user_logged_in() ) { $output["Discount"] = "-" . $discount * 100 . "%"; }
		// if ( $wlasnosc && is_user_logged_in() ) { $output["Własność"] = $wlasnosc[0]; }

		if ( $foil = get_post_meta($post->ID, 'foil') ) {
			if ( $foil[0] == 1 ) {
				$output['Edycja'] = $output['Edycja'] . '<small> Foil </small><i class="dashicons dashicons-star-empty"></i>';
				if ( get_field( "cena_karty_foil", "options" ) ) {
					$output["Cena"] = CurrencyCalculator\convertCurrency($output["Cena"] * ( 1 - $discount + get_field( "cena_karty_foil", "options" ) ));
				}
			} else {
				$output["Cena"] = CurrencyCalculator\convertCurrency($output["Cena"] * ( 1 - $discount ));
			}
		}

		return $output;

	} else {

		return;

	}

}

function get_conditions_array() {

	return get_meta_values_array( 'stan' );

}

function get_languages_array() {

	return get_meta_values_array( 'jezyk' );

}

function get_owners_array() {

	return get_meta_values_array( 'własność' );
}

function get_meta_values_array( $key, $type = 'post', $status = 'publish' ) {

	global $wpdb;

	if( empty( $key ) )
		return;

	$r = $wpdb->get_col( $wpdb->prepare( "
		SELECT pm.meta_value FROM {$wpdb->postmeta} pm
		LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
		WHERE pm.meta_key = '%s'
		AND p.post_status = '%s'
		AND p.post_type = '%s'
		", $key, $status, $type ) );

	return array_unique($r);

}

function get_owners_cards_query($owner) {

	$args = array (
		'post_type'             => array( 'post' ),
		'posts_per_page'        => -1,
		'order'                 => 'ASC',
		'orderby'               => 'title',
		'meta_query'            => array(
			array(
				'key'       => 'własność',
				'value'     => $owner,
				'compare'   => '=',
			),
		),
		'cache_results'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	);

// The Query
	$query = new \WP_Query( $args );

	return $query;

}

function get_owners_cards_query_by_price($owner) {

	$args = array (
		'post_type'             => array( 'post' ),
		'posts_per_page'        => -1,
		'order'                 => 'DESC',
		'orderby'               => 'meta_value_num',
		'meta_key'              => 'cena',
		'meta_query'            => array(
			array(
				'key'       => 'własność',
				'value'     => $owner,
				'compare'   => '=',
			),
		),
		'cache_results'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	);

// The Query
	$query = new \WP_Query( $args );

	return $query;

}

function get_baskets_query() {

	$args = array (
		'post_type'             => array( 'basket' ),
		'posts_per_page'        => -1,
		'order'                 => 'DESC',
		'orderby'               => 'date',
		'cache_results'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	);

// The Query
	$query = new \WP_Query( $args );

	return $query;

}
