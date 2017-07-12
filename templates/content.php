<?php use Roots\Sage\Utils; ?>
<?php $is_foil = get_post_meta($post->ID, 'foil'); ?>

<div class="row" data-foil="<?php if ( array_key_exists(0, $is_foil) && $is_foil[0] == 1 ) { echo 'yellow'; } else { echo "0"; } ?>" data-id="<?php echo $post->ID; ?>">
  <div class="small-3 columns">
    <div class="row">
      <div class="small-12 columns">
        <?php if ( get_post_meta($post->ID, 'img_link') ) { ?>
        <span data-tooltip aria-haspopup="true" class="has-tip" data-options="show_on:large" title="<img src='<?php echo get_post_meta($post->ID, 'img_link')[0]; ?>'>">
          <?php the_title(); ?>
        </span>
        <?php } else { ?>
        <span><?php the_title(); ?></span>
        <?php } ?>
        <?php if ( get_post_meta($post->ID, 'uwagi')[0] ) { ?>
        &nbsp;
        <span data-tooltip aria-haspopup="true" class="has-tip" data-options="show_on:large" title="<?php echo get_post_meta($post->ID, 'uwagi')[0]; ?>">
          <i class="dashicons dashicons-info"></i>
        </span>
        <?php } ?>
        <?php if ( $link = get_post_meta($post->ID, "link_do_karty") ) { ?>
        <a href="<?php echo $link[0]; ?>" class="" title="Zobacz <?php the_title(); ?> na MKM" target="_blank">
          <i class="dashicons dashicons-admin-links text-success"></i>
        </a>
        <a href="wp-admin/post.php?post=<?php echo $post->ID;?>&action=edit" class="">
          <i class="dashicons dashicons-edit text-warning"></i>
        </a>
        <?php } ?>
      </div>
      <?php foreach ( Utils\get_meta_array() as $key => $name ) { ?>
      <div class="<?php echo $key; ?> small-<?php echo $key === "Edycja" ? "12" : "1"; ?> columns <?php echo $key !== "Edycja" ? "text-center" : ""; ?>"<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?> data-<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>="<?php echo $name;?>"<?php } ?>>

        <?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>

        <a href="#" class="change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="-1"><i class="dashicons dashicons-minus text-alert"></i></a>

        <?php } ?>

        <span><?php if ( $key === "Ilość" || $key === "Sprzedane" ) { ?><small><?php } ?><?php echo $name; ?><?php if ( $key === "Ilość" || $key === "Sprzedane" ) { ?></small><?php } ?></span>

        <?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>

        <a href="#" class="change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="1"><i class="dashicons dashicons-plus text-success"></i></a>

        <?php } ?>
        
      </div>
      <?php if ( $key === "Edycja") { ?>
    </div>
  </div>
  <?php } ?>
  <?php } ?>
  <?php if (is_user_logged_in()) { ?>
  <div class="small-1 columns">
    <div class="management-icons">
      <a href="#" class="post-delete" title="<?php _e("Move card to trash", "sage"); ?>">
        <i class="dashicons dashicons-trash"></i>
      </a>
      <a href="#" class="post-freeze" title="<?php _e("Freeze card price", "sage"); ?>">
      <?php if ( get_field("price_frozen") ) { ?>
        <i class="dashicons dashicons-lock text-alert"></i>
        <i class="dashicons dashicons-unlock text-success hide"></i>
      <?php } else { ?>
        <i class="dashicons dashicons-lock text-alert hide"></i>
        <i class="dashicons dashicons-unlock text-success"></i>
      <?php } ?>
      </a>
      <a href="#" class="post-update" title="<?php _e("Update card price", "sage"); ?>">
        <i class="dashicons dashicons-update dashicons-x2 text-primary"></i>
      </a>
    </div>
  </div>
  <?php } ?>
  <div class="small-12 columns">
    <div class="divider"></div>
  </div>
</div>
