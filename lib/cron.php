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

function update_cards_prices( $posts_per_page = 100 ) {

	if ( $posts_per_page > 0 ) {

		$step = get_field( "krok_dla_cron", "options" );

	} else {

		$step = 1;
	}

// WP_Query arguments
	$args = array (
		'post_type'              	=> array( 'post' ),
		'paged'					 	=> $step,
		'posts_per_page'			=> $posts_per_page,
		'order'                  	=> 'ASC',
		'orderby'                	=> 'title',
		'meta_query'             	=> array(
			array(
				'key'       => 'rarity',
				'value'     => 'Error',
				'compare'   => '!=',
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
			// run api script to update card's price
			// print_r(array(get_the_title(), $post->ID, $is_foil));
			// echo "<br>";
			$price = MKM_update_price( $post->ID, $is_foil );
			// echo "<hr>";

			if ( $query->current_post + 1 === $query->post_count ) {
				update_field( "ostatnia_karta", get_the_title() . " - " . $price . " zł", "options" );
			}
			// print updated cards in table
				// get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format());
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

	return get_field( "krok_dla_cron", "options" );
}