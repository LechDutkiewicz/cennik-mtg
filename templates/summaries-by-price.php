<?php
use Roots\Sage\Utils;

$owners = Utils\get_owners_array();

?>

<ul class="accordion" data-accordion>

  <?php
  foreach ($owners as $owner) {

    $query = Utils\get_owners_cards_query_by_price($owner);

    if ( $query->have_posts() ) { ?>

    <li class="accordion-navigation">
      <div id="panel-<?php echo $owner; ?>" class="content">
        <div class="row">
          <div class="column small-6"><?php _e('Owner', 'sage'); ?></div>
          <div class="column small-2"><?php _e('Amount of cards', 'sage'); ?></div>
          <div class="column small-2"><?php _e('Total value', 'sage'); ?></div>
          <div class="column small-2"><?php _e('Cumulated value', 'sage'); ?></div>

          <?php
          $amount = 0;
          $total_value = 0;

          while ( $query->have_posts() ) {
            $query->the_post();
            $card_amount = get_post_meta( $post->ID, 'ilosc');
            $amount += is_array($card_amount) ? $card_amount[0] : 0;

            $card_value = get_post_meta( $post->ID, 'cena');
            $total_value += is_array($card_value) ? $card_amount[0] * $card_value[0] : 0;
            ?>

            <div class="column small-6">
              <?php
              the_title();
              if ( $link = get_post_meta($post->ID, "link_do_karty") ) {
                ?>
                <a href="wp-admin/post.php?post=<?php echo $post->ID;?>&action=edit" class="dashicons dashicons-edit"></a>
                <?php
              }
              ?>
            </div>
            <div class="column small-2">
              <?php echo is_array($card_amount) ? $card_amount[0] : __('Error', 'sage'); ?>
            </div>
            <div class="column small-2">
              <?php echo is_array($card_value) ? $card_value[0] : __('Error', 'sage'); ?>
            </div>
            <div class="column small-2">
              <?php echo $total_value; ?>
            </div>
            <div class="clearfix"></div>

            <?php
          }
          ?>

        </div>
      </div>

      <a href="#panel-<?php echo $owner; ?>">
        <div class="row">
          <div class="column small-4">
            <?php echo $owner; ?>
          </div>
          <div class="column small-4">
            <?php echo $amount; ?>
          </div>
          <div class="column small-4">
            <?php echo $total_value; ?>
          </div>
        </div>
      </a>
    </li>
    <?php }
    wp_reset_postdata();
  } ?>

</ul>

