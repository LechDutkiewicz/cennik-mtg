<?php
use Roots\Sage\CurrencyCalculator;

$is_foil = get_post_meta($post->ID, 'foil');

$owner = get_post_meta( $post->ID, "własność");
$set = get_post_meta( $post->ID, "edycja")[0];
$condition = get_post_meta( $post->ID, "stan")[0];
if (!isset($price)) { $price = get_post_meta( $post->ID, "cena")[0]; }
$discount = get_post_meta( $post->ID, "discount");
$updated_price = array_key_exists( 0, $discount ) ? CurrencyCalculator\fmtMoney( $price * ( 1 - $discount[0] ) ) : $price;
$amount = get_post_meta( $post->ID, "ilosc")[0];
?>

<tr data-foil="<?php if ( array_key_exists(0, $is_foil) && $is_foil[0] == 1 ) { echo 'yellow'; } else { echo "0"; } ?>"
	data-id="<?php echo $post->ID; ?>"
	data-owner="<?php echo array_key_exists( 0, $owner ) ? $owner[0] : __( "Unset", "sage" ); ?>">
	<!-- card name -->
	<td>
		<?php if ( get_post_meta($post->ID, 'img_link') ) { ?>
		<!-- tooltip with image -->
		<span data-tooltip aria-haspopup="true" class="has-tip" data-options="show_on:large" title="<img src='<?php echo get_post_meta($post->ID, 'img_link')[0]; ?>'>">
			<?php the_title(); ?>
		</span>
		<?php } else { ?>
		<!-- card name -->
		<span><?php the_title(); ?></span>
		<?php } ?>

		<?php if ( $link = get_post_meta($post->ID, "link_do_karty") ) { ?>
		<!-- link to mkm page with current card -->
		<a href="<?php echo $link[0]; ?>" class="" title="Zobacz <?php the_title(); ?> na MKM" target="_blank" data-email-swap>
			<i class="dashicons dashicons-admin-links text-success"></i>
		</a>
		<!-- link to edit current card in cms -->
		<a href="wp-admin/post.php?post=<?php echo $post->ID;?>&action=edit" class="" data-email-swap>
			<i class="dashicons dashicons-edit text-warning"></i>
		</a>
		<?php } ?>
	</td>
	<!-- card expansion -->
	<td>
		<?php echo $set; ?>
		<?php if ( array_key_exists(0, $is_foil) && $is_foil[0] == 1 ) { echo ' FOIL'; } else { echo ""; } ?>
	</td>
  <!-- card owner -->
  <td data-email-swap>
    <span class="Własność"><?php echo array_key_exists( 0, $owner ) ? $owner[0] : __( "Unset", "sage" ); ?></span>
    <a href="#" class="post-update" title="<?php _e("Update card price"); ?>">
      <i class="dashicons dashicons-update text-primary"></i>
    </a>
    <a href="#" class="post-hide" title="<?php _e("Remove from basket"); ?>">
      <i class="dashicons dashicons-no text-alert"></i>
    </a>
  </td>
	<!-- card condition -->
	<td class="text-center">
		<?php echo $condition; ?>
	</td>
	<!-- card price -->
	<td class="Cena text-center">
		<button type="button" class="no-margin button alert super-tiny button-number"  data-type="minus" data-field="price[<?php echo $post->ID; ?>]" data-email-swap>
			<span class="dashicons dashicons-minus"></span>
		</button>
		<input type="text" name="price[<?php echo $post->ID; ?>]" class="no-margin inline-block super-tiny input-number" data-target="price[<?php echo $post->ID; ?>]" value="<?php echo $updated_price; ?>" min="0" max="5000" data-email-swap>
		<span class="hide" data-source="price[<?php echo $post->ID; ?>]" data-email-swap><?php echo $updated_price; ?></span>
		<button type="button" class="no-margin button success super-tiny button-number" data-type="plus" data-field="price[<?php echo $post->ID; ?>]" data-email-swap>
			<span class="dashicons dashicons-plus"></span>
		</button>
	</td>
	<!-- card available -->
	<td data-email-swap class="text-center">
		<?php echo $amount;?>
	</td>
	<!-- card amount for sale -->
	<td class="text-center">
		<button type="button" class="no-margin button alert super-tiny button-number"  data-type="minus" data-field="quant[<?php echo $post->ID; ?>]" data-email-swap>
			<span class="dashicons dashicons-minus"></span>
		</button>
		<input type="text" name="quant[<?php echo $post->ID; ?>]" class="no-margin inline-block super-tiny input-number" data-target="quant[<?php echo $post->ID; ?>]" value="<?php echo isset($amount_sold) ? $amount_sold : 0; ?>" min="0" max="<?php echo $amount; ?>" data-email-swap>
		<span class="hide" data-source="quant[<?php echo $post->ID; ?>]" data-email-swap><?php echo isset($amount_sold) ? $amount_sold : 0; ?></span>
		<button type="button" class="no-margin button success super-tiny button-number" data-type="plus" data-field="quant[<?php echo $post->ID; ?>]" data-email-swap>
			<span class="dashicons dashicons-plus"></span>
		</button>
	</td>
</tr>
