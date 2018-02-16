<?php
/**
 * Template Name: Order by price
 */
use Roots\Sage\Utils;

$meta_array = Utils\get_meta_array();

if ( is_user_logged_in() ) {
	get_template_part('templates/page', 'header');
}

if (!have_posts()) { ?>
<div data-alert class="alert-box warning">
	<?php _e('You don\'t have any cards added yet.', 'sage'); ?>
	<a href="#" class="close">&times;</a>
</div>
<?php } else { ?>

<ul class="tabs" data-tab>
	<?php $rarities = Utils\get_rarities(); ?>
	<?php foreach ( $rarities as $key => $rarity ) { ?>
	<li class="tab-title<?php echo $key === 0 ? " active" : ""; ?>"><a href="#panel<?php echo $key + 1; ?>"><?php echo $rarity; ?></a></li>
	<?php } ?>
</ul>
<div class="tabs-content">
	<?php foreach ( $rarities as $key => $rarity ) { ?>
	<div class="content row<?php echo $key === 0 ? " active" : ""; ?>" id="panel<?php echo $key + 1; ?>">

		<?php
// WP_Query arguments
		$args = array (
			'post_type'             => array( 'post' ),
			'posts_per_page'    => get_option('posts_per_page'),
			'paged'         => 1,
			'order'                 => 'DESC',
			'orderby'               => 'meta_value_num',
			'meta_key'              => 'cena',
			'meta_query'            => array(
				array(
					'key'       => 'rarity',
					'value'     => $key + 1,
					'compare'   => '=',
				),
			),
			'cache_results'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
		);

// The Query
		$query = new WP_Query( $args );
		?>

		<div class="small-12 columns cards-list">
			<div class="row">

				<?php
// The Loop
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
		// do something
						get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format());
					}
				} else {
	// no posts found
				}
				?>
			</div>

		</div>
		<div class="small-12 columns">
			<hr>
			<a href="#" class="button load-more" data-rarity="<?php echo $key; ?>" data-order="DESC" data-orderby="meta_value_num" data-meta-key="cena" data-paged="1">Load mode</a>
		</div>
	</div>
	<?php
// Restore original Post Data
	wp_reset_postdata(); } ?>
</div>
<?php
}
?>
