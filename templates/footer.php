<footer class="content-info" role="contentinfo">
  <div class="container">
    <?php //dynamic_sidebar('sidebar-footer'); ?>
  </div>
  <script type="text/javascript">
  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  </script>
</footer>

<div id="basket-modal" class="reveal-modal row" data-reveal aria-labelledby="basket-modal-title" aria-hidden="true" role="dialog">
  <div class="small-12 columns">
    <h2 id="basket-modal-title"><?php _e( "Add cards", "sage" ); ?></h2>
  </div>
  <?php get_template_part("templates/search", "basket"); ?>
  <div class="small-12 columns alert-container"></div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="add-card-modal" class="reveal-modal" data-reveal aria-labelledby="add-card-modal-title" aria-hidden="true" role="dialog">
  <div class="row">
    <div class="small-12 columns">
      <h2 id="add-card-modal-title"><?php _e("Add new card"); ?></h2>
    </div>
  </div>
  <?php get_template_part("templates/add", "post"); ?>
  <div class="row">
    <div class="small-12 columns alert-container"></div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<div class="scroll-top-wrap">
  <div class="scroll-top-inner">
    <i class="dashicons dashicons-arrow-up-alt"></i>
  </div>
</div>
