<?php
/**
 * Template Name: Forum
 */
use Roots\Sage\Utils; ?>
<textarea name="" id="content_to_paste" cols="30" rows="10">
<?php the_field( "Forum_content", "options" ); ?>


	<?php $rarities = Utils\get_rarities();
	foreach ( $rarities as $key => $rarity ) {
// WP_Query arguments
	$args = array (
		'post_type'              => array( 'post' ),
		'posts_per_page'		 => -1,
		'order'                  => 'ASC',
		'orderby'                => 'title',
		'meta_query'             => array(
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
// The Loop
	if ( $query->have_posts() ) { ?>
[size=150]<?php echo $rarity;?>[/size]

<?php while ( $query->have_posts() ) {
		$query->the_post();
		// do something
		get_template_part('templates/forum', get_post_type() != 'post' ? get_post_type() : get_post_format());
	}
} else {
	// no posts found
}
// Restore original Post Data
wp_reset_postdata();
} ?>
</textarea>

<div class="row">
	<div class="small-12 columns form-container">
		<h2>Zmiana treści przed listą kart</h2>
		<form action="" id="forum-content">
			<label for="forum_content">Tutaj możesz edytować treści
				<textarea name="forum_content" id="forum_content" cols="30" rows="10"><?php the_field( "Forum_content", "options" ); ?>
				</textarea>
			</label>
			<input class="button" name="submit" id="submit" type="submit" value="Aktualizuj">
		</form>
		<div class="msg-container"></div>		
	</div>
</div>