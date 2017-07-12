<?php if ( is_user_logged_in() ) { ?>
<div class="sticky">
  <nav class="top-bar" data-topbar role="navigation">

    <section class="middle tab-bar-section">
      <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
      <div class="right">
        <a href="#" data-reveal-id="basket-modal" class="dashicons dashicons-cart dashicons-x2 text-alert">
        </a>
        <a href="#" data-reveal-id="add-card-modal" class="dashicons dashicons-plus dashicons-x2 text-secondary">
        </a>
      </div>
    </section>

    <?php if (is_user_logged_in()) { ?>
    <section class="left-small">
      <a href="#" class="left-off-canvas-toggle menu-icon dashicons dashicons-menu dashicons-x2 text-secondary"><span></span></a>
    </section>
    <?php } ?>

    <section class="right-small">
      <?php if (is_user_logged_in()) { ?>
      <!-- <a href="#" class="top-off-canvas-toggle dashicons dashicons-plus"></a> -->
      <?php } else { ?>
      <a href="#" class="top-off-canvas-toggle dashicons dashicons-admin-users text-secondary"></a>
      <?php } ?>
    </section>

  </nav>
</div>
<?php } ?>
