<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
      <![endif]-->
      <?php
      do_action('get_header');
      ?>
      <div class="off-canvas-wrap docs-wrap" role="document" data-offcanvas>
        <div class="inner-wrap">
          <?php get_template_part('templates/header'); ?>          
          <!-- Off Canvas Menu -->
          <?php if ( !is_user_logged_in() ) { ?>
          <aside class="top-off-canvas-menu" role="complementary">
            <div class="row">
              <div class="small-12 columns">
                <div class="text-white">
                  <?php wp_login_form(); ?>
                </div>
              </div>
            </div>
          </aside>
          <?php } ?>

          <?php if (is_user_logged_in()) { ?>
          <aside class="left-off-canvas-menu">
            <?php if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
            endif; ?>
          </aside>
          <?php } ?>

          <!-- main content goes here -->
          <div class="content row">
            <main class="main small-12 columns" role="main">
              <?php include Wrapper\template_path(); ?>
            </main><!-- /.main -->
          </div><!-- /.content -->

          <!-- close the off-canvas menu -->
          <a class="exit-off-canvas"></a>

        </div>
      </div><!-- /.wrap -->
      <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
      ?>
    </body>
    </html>
