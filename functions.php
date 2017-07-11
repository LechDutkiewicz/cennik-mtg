<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/utils.php',                 // Utility functions
  'lib/init.php',                  // Initial theme setup and constants
  'lib/wrapper.php',               // Theme wrapper class
  'lib/conditional-tag-check.php', // ConditionalTagCheck class
  'lib/config.php',                // Configuration
  'lib/assets.php',                // Scripts and stylesheets
  'lib/titles.php',                // Page titles
  'lib/post-types.php',             // Custom post types
  'lib/mkmapi.php',
  'lib/extras.php',                // Custom functions
  'lib/ajax-methods.php',
  'lib/currency-calculator.php',
  'lib/cron.php'
  ];

  foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
      trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
  }

  if ( WP_ENV === 'production' && DIST_DIR ) {
    $prefix = DIST_DIR;
  } else {
    $prefix = '/assets/';
  }

  $sage_extensions = [
  // $prefix . 'extensions/mobble/mobble.php',                        // Mobble plugin mobile devices detection https://github.com/scottsweb/mobble
  // $prefix . 'extensions/advanced-custom-fields/acf.php',           // Advanced Custom Fields Extension
  // $prefix . 'extensions/acf-font-awesome/acf-font-awesome.php',    // Advanced Custom Fields Font Awesome Extension
  // $prefix . 'extensions/acf-repeater/acf-repeater.php',            // Advanced Custom Fields Repeater Extension
  // $prefix . 'extensions/acf-options-page/acf-options-page.php',    // Advanced Custom Fields Repeater Extension
  // $prefix . 'extensions/acf-categories/acf-categories.php',        // Advanced Custom Fields Categories Extension
  // $prefix . 'extensions/acf-gallery/acf-gallery.php',              // Advanced Custom Fields Gallery Extension
  // $prefix . 'extensions/acf-video/acf-video.php',                  // Advanced Custom Fields Contact Form 7
  // $prefix . 'extensions/aq-resizer/aq_resizer.php',                // Advanced Custom Fields Contact Form 7
  'lib/custom-fields.php'                                       // Custom fields for the template
  ];

  foreach ($sage_extensions as $file) {
    if (!$filepath = locate_template($file)) {
      trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
  }
  
  unset($file, $filepath);

  function my_pre_get_posts( $query ) {

  // do not modify queries in the admin
    if( is_admin() ) {

      return $query;

    }


  // only modify queries for 'event' post type
    // $query->set('orderby', 'meta_value_num'); 
    // $query->set('meta_key', 'rarity');
    // $query->set('order', 'ASC');


  // return
    return $query;

  }

  add_action('pre_get_posts', 'my_pre_get_posts');
