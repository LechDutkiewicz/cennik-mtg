<?php use Roots\Sage\Utils;
use Roots\Sage\CurrencyCalculator;

if ( !is_user_logged_in() ) { ?>

<div class="panel"><?php wp_login_form();?></div>

<?php } else {

	$meta_array = Utils\get_meta_array();

	?>

	<?php get_template_part('templates/page', 'header'); ?>

	<?php if (!have_posts()) { ?>
	<div data-alert class="alert-box warning">
		<?php _e('You don\'t have any cards added yet.', 'sage'); ?>
		<a href="#" class="close">&times;</a>
	</div>
	<?php } else { ?>

  <div class="row">

    <div class="column small-12 medium-4">

      <div class="panel">
        <p>
          <?php $schedule = wp_get_schedule( 'update_cards' );
      // echo $schedule;
      // var_dump( wp_next_scheduled( 'update_cards' ) );
          if ( $schedule === "Once a Minute" ) {
            wp_unschedule_event(wp_next_scheduled( 'update_cards' ), 'update_cards');
            echo __( "Prices update runs every", "sage" ) . " " . __( "minute", "sage");
          } else if ( $schedule === "hourly" ) {
            wp_unschedule_event(wp_next_scheduled( 'update_cards' ), 'update_cards');
            echo __( "Prices update runs every", "sage" ) . " " . __( "hour", "sage");
          } else if ( $schedule === "daily" ) {
            echo __( "Prices update runs every", "sage" ) . " " . __( "friday", "sage");
          }?>
        </p>
        <p>
          <?php the_field( "ostatnie_wykonanie", "options" ); ?>
        </p>
        <p>
          <?php echo __( "Name of last updated card: ", "sage" ) . get_field( "ostatnia_karta", "options" ); ?>
        </p>
      </div>

    </div>

    <div class="column small-12 medium-8">

      <div class="panel">

        <?php get_template_part('templates/summaries'); ?>

      </div>

    </div>
  </div>

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
      'posts_per_page'		    => get_option('posts_per_page'),
      'paged'					        => 1,
      'order'                 => 'ASC',
      'orderby'               => 'title',
      'meta_query'            => array(
       array(
        'key'                           => 'rarity',
        'value'                         => $key + 1,
        'compare'                       => '=',
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
       <div class="small-3 columns">
        <div class="row">
         <div class="small-12 columns">
          <span>Nazwa karty</span>
        </div>
        <?php foreach ( $meta_array as $meta_key => $name ) { ?>
        <div class="small-<?php echo $meta_key === "Edycja" ? "12" : "1"; ?> columns">
          <span><?php echo $meta_key; ?></span>
        </div>
        <?php if ( $meta_key === "Edycja" ) { ?>
      </div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if (is_user_logged_in()) { ?><div class="small-1 columns">Akcje</div><?php } ?>
  </div>
  <hr>

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
<div class="small-12 columns">
  <hr>
  <a href="#" class="button load-more" data-rarity="<?php echo $key; ?>" data-paged="1">Load mode</a>
</div>
</div>
<?php
// Restore original Post Data
wp_reset_postdata(); } ?>
</div>
<?php }
} ?>
<?php //print_r(MKM_API('Tarmogoyf')); ?>
