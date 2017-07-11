<?php
use Roots\Sage\Utils;
$meta_array = Utils\get_meta_headers();
?>
<div class="column small-7">
  <?php get_template_part("templates/searchform"); ?>
</div>
<div class="column small-5">
  <ul class="button-group">
    <li>
      <button id="reset-basket" class="warning small radius"><?php _e( 'Clear view', 'sage' ); ?></button>
    </li>
    <?php
    $query = Utils\get_baskets_query();
    if ( $query->have_posts() ) {
      ?>
      <button href="#" data-dropdown="baskets-drop" aria-controls="baskets-drop" aria-expanded="false" class="small radius dropdown"><?php _e( 'Load cart', 'sage' ); ?></button><br>
      <ul id="baskets-drop" data-dropdown-content class="f-dropdown" aria-hidden="true">
        <?php
        while ( $query->have_posts() ) {
          $query->the_post();
          ?>
          <li><a href="#" data-basket-id="<?php echo $post->ID; ?>"><?php the_title(); ?></a></li>
          <?php
        }
        ?>
      </ul>
      <?php
    }
    ?>
  </ul>
</div>
<div class="column small-12">
  <input type="text" id="basket-name" name="basket-name" class="inline-block" placeholder="<?php _e('Customer\'s name', 'sage'); ?>">
</div>
<div class="column small-12">
  <table id="basket-table" class="hover fw" data-basket-id="">
    <thead>
      <tr>
        <th><?php _e( "Name", "sage" ); ?></th>
        <th><?php _e( "Expansion", "sage" ); ?></th>
        <th class="text-center" data-email-swap><?php _e( "Extras", "sage" ); ?></th>
        <th class="text-center"><?php _e( "Condition", "sage" ); ?></th>
        <th class="text-center"><?php _e( "Price", "sage" ); ?></th>
        <th class="text-center" data-email-swap><?php _e( "Available", "sage" ); ?></th>
        <th class="text-center"><?php _e( "Sell", "sage" ); ?></th>
      </tr>
    </thead>
    <tbody class="list">
    </tbody>
    <tbody class="summary">
      <tr>
        <td><?php _e( "Discount", "sage" ); ?>: <span class="discount" data-source="discount">0</span>&nbsp;zł</td>
        <td><?php _e( "KP", "sage" ); ?>: <span class="shipping-cost" data-source="shipping-cost"></span></td>
        <td><?php _e( "Total", "sage" ); ?>: <span class="total-sum total"></span></td>
        <td colspan="4"></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="column small-12">
  <div class="row">
    <div class="column small-4">
      <table class="fw">
        <tbody>
          <tr>
            <td><?php _e( "Team", "sage" ); ?></td>
            <td><span class="total-sum team"></span></td>
          </tr>
          <tr>
            <td><?php _e( "Leszek", "sage" ); ?></td>
            <td><span class="total-sum leszek"></span></td>
          </tr>
          <tr>
            <td><?php _e( "Sławek", "sage" ); ?></td>
            <td><span class="total-sum slawek"></span></td>
          </tr>
          <tr>
            <td><?php _e( "Total", "sage" ); ?></td>
            <td><span class="total-sum total"></span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="column small-8">
      <table class="fw">
        <tbody>
          <tr>
            <td><?php _e( "Discount", "sage" ); ?></td>
            <td>
              <button type="button" class="no-margin button alert super-tiny button-number"  data-type="minus" data-field="quant-discount">
                <span class="dashicons dashicons-minus"></span>
              </button>
              <input type="text" name="quant-discount" class="no-margin inline-block super-tiny input-number" data-target="discount" value="0" min="0" max="100">
              <button type="button" class="no-margin button success super-tiny button-number" data-type="plus" data-field="quant-discount">
                <span class="dashicons dashicons-plus"></span>
              </button>
            </td>
          </tr>
          <tr>
            <td><?php _e( "KP", "sage" ); ?></td>
            <td>
              <button type="button" class="no-margin button alert super-tiny button-number"  data-type="minus" data-field="quant-shipping-cost">
                <span class="dashicons dashicons-minus"></span>
              </button>
              <input type="text" name="quant-shipping-cost" class="no-margin inline-block super-tiny input-number" data-target="shipping-cost" value="6" min="0" max="50">
              <button type="button" class="no-margin button success super-tiny button-number" data-type="plus" data-field="quant-shipping-cost">
                <span class="dashicons dashicons-plus"></span>
              </button>
            </td>
          </tr>
          <tr>
            <td><?php _e( "Cart status", "sage" ); ?></td>
            <td>
              <!-- <select name="basket-status" id="basket-status" disabled="true">
                <option value="preorder"><?php _e( 'Pre order', 'sage' ); ?></option>
                <option value="shipped"><?php _e( 'Shipped', 'sage' ); ?></option>
                <option value="billed"><?php _e( 'Billed', 'sage' ); ?></option>
              </select> -->
              <span id="basket-status" class="label" data-status="preorder"><?php _e( 'Pre order', 'sage' ); ?></span>
            </td>
          </tr>
          <tr>
            <td>

            </td>
            <td>
              <ul class="button-group" style="margin-top:20px;text-align:right;">
                <li>
                  <!-- <button id="update-status" class="info small radius" data-basket-id=""><?php _e( 'Update cart status', 'sage' ); ?></button> -->
                  <button class="update-status hide info tiny radius" data-status="shipped" data-basket-id=""><i class="dashicons dashicons-share-alt2"></i>&nbsp;<?php _e( 'Mark as shipped', 'sage' ); ?></button>
                </li>
                <li>
                  <button class="update-status hide info tiny radius" data-status="billed" data-basket-id=""><i class="dashicons dashicons-money"></i>&nbsp;<?php _e( 'Mark as billed', 'sage' ); ?></button>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div id="basket-summaries" class="column small-12">
  <div class="row">
    <div class="column small-4">
      <div class="msg-container"></div>
    </div>
    <div class="column small-8 text-right">
      <ul class="button-group">
        <li>
          <button id="remove-basket" class="hide alert small radius" data-basket-id=""><i class="dashicons dashicons-trash"></i>&nbsp;<?php _e( 'Remove cart', 'sage' ); ?></button>
        </li>
        <li>
          <button id="email-friendly" class="success small radius"><i class="dashicons dashicons-email-alt"></i>&nbsp;<?php _e( 'E-mail view', 'sage' ); ?></button>
        </li>
        <li>
          <button id="save-basket" class="info small radius"><i class="dashicons dashicons-plus-alt"></i>&nbsp;<?php _e( 'Save cart', 'sage' ); ?></button>
        </li>
      </ul>
    </div>
  </div>
</div>
