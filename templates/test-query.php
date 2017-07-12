<?php

$step = get_field( "krok_dla_cron", "options" );

// WP_Query arguments
$args = array (
	'post_type'              	=> array ( 'post' ),
	'paged'					 	=> 1,
	'posts_per_page'			=> 10,
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

// The Loop
if ( $query->have_posts() ) {
	?>
	<ul>
		<?php
		while ( $query->have_posts() ) {
			$query->the_post();

			$is_frozen = get_post_meta( $post->ID, "price_frozen" );
			?>
			<li><?php the_title(); ?> | <?= $is_frozen[0]; ?> | <?= $post->ID; ?></li>
			<?php
		}
		?>
	</ul>
	<?php
}
// wp_reset_postdata();
wp_reset_query();

?>