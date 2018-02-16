<?php

// require_once("../../../../wp-load.php");
// require_once("mkmapi.php");

function addCronMinutes($array) {
	$array['minute'] = array(
		'interval' => 60,
		'display' => 'Once a Minute',
	);
	return $array;
}
add_filter('cron_schedules','addCronMinutes');

if ( ! wp_next_scheduled( 'update_cards' ) ) {
	wp_schedule_event( time(), 'daily', 'update_cards' );
}

add_action( 'update_cards', 'update_cards_prices' );

/**
 *
 * update_cards_prices
 * aktualizuje określoną liczbę kart według pola zapisanego w cron
 * @param $posts_per_page = ilość kart do zaktualizowania za jednym razem
 *
 */


function update_cards_prices( $posts_per_page = 50 ) {

	if ( $posts_per_page > 0 ) {

		$step = get_field( "krok_dla_cron", "options" );

	} else {

		$step = 1;
	}

	// WP_Query arguments
	$args = array (
		'post_type'              	=> array ( 'post' ),
		'paged'					 	=> $step,
		'posts_per_page'			=> $posts_per_page,
		'order'                  	=> 'ASC',
		'orderby'                	=> 'title',
		'meta_query'             	=> array (
			'relation'		=> 'OR',
			array (
				'relation'		=> 'AND',
				array(
					'key'       => 'rarity',
					'value'     => 'Error',
					'compare'   => '!=',
				),
				array (
					'key'       => 'price_frozen',
					'compare'   => 'NOT EXISTS',
				)
			),
			array (
				'relation'		=> 'AND',
				array(
					'key'       => 'rarity',
					'value'     => 'Error',
					'compare'   => '!=',
				),
				array (
					'key'       => 'price_frozen',
					'value'     => '1',
					'compare'   => 'NOT LIKE',
				)
			),
		),
		'cache_results'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	);

	// The Query
	$query = new WP_Query( $args );
	?>

	<?php
		// The Loop
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			global $post;
			// check if card is foil
			$post_meta = get_post_meta($post->ID, 'foil');
			$is_foil = empty($post_meta[0]) ? null : 1;

			// zrób API call
			$mkm_response = MKM_update_price( $post->ID, $is_foil );

			if ( $query->current_post + 1 === $query->post_count ) {
				update_field( "ostatnia_karta", get_the_title() . " - " . $mkm_response["price_pln"] . " zł", "options" );
			}
		}

		// check if we're on the last page of posts
		if ( $step < $query->max_num_pages ) {
			// update next page of posts next execution
			update_field( "krok_dla_cron", $step + 1, "options" );

		} else {
			// go back to first page of posts and start updating from there again
			update_field( "krok_dla_cron", 1, "options" );

		}

	} else {
	// no posts found
	}
// Restore original Post Data

	wp_reset_postdata();
	$date = new dateTime();
	update_field( "ostatnie_wykonanie", sprintf(__( "Script was completed last time at: %s", "sage"), $date->format("d-m-Y H:i:s"), "options") );
	?>

	<?php

	$return_data = array (
		"ostatnia_karta"	=> get_field( "ostatnia_karta", "options" ),
		"zaktualizowano"	=> $posts_per_page
	);

	return $return_data;
}