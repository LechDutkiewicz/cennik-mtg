<form id="search" role="search" method="get" class="search" action="">
  <div class="row">
    <div class="small-12 columns">
      <div class="row collapse">
        <div class="small-10 columns">
          <input id="s" type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e('Search', 'sage'); ?> <?php bloginfo('name'); ?>">
          <input id="card-id" type="hidden" name="card-id">
        </div>
        <div class="small-2 columns">
          <button type="submit" class="button postfix"><?php _e('Add card', 'sage'); ?> <i class="dashicons dashicons-plus"></i></button>
        </div>
      </div>
    </div>
  </div>
</form>