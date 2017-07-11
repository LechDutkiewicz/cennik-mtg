<?php use Roots\Sage\Utils; ?>
<?php $is_foil = get_post_meta($post->ID, 'foil'); ?>

<tr data-foil="<?php if ( array_key_exists(0, $is_foil) && $is_foil[0] == 1 ) { echo 'yellow'; } else { echo "0"; } ?>" data-id="<?php echo $post->ID; ?>">
	<td>
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
		<a href="<?php echo $link[0]; ?>" class="dashicons dashicons-admin-links" title="Zobacz <?php the_title(); ?> na MKM" target="_blank"></a>
		<?php } ?>
	</td>
	<?php foreach ( Utils\get_meta_array() as $key => $name ) { ?>
	<td class="<?php echo $key; ?>"<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?> data-<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>="<?php echo $name;?>"<?php } ?>>
		<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>
		<a href="#" class="change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="-1">
			<i class="dashicons dashicons-minus"></i>
		</a>
		<?php } ?>
		<span>
			<?php if ( $key === "Edycja" || $key === "Własność" || $key === "Discount" ) { ?><?php } ?>
			<?php echo $name; ?>
			<?php if ( $key === "Edycja" || $key === "Własność" || $key === "Discount" ) { ?><?php } ?>
		</span>
		<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>
		<a href="#" class="change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="1">
			<i class="dashicons dashicons-plus"></i>
		</a>
		<?php } ?>
	</td>
	<?php } ?>
	<?php if (is_user_logged_in()) { ?>
	<td>
		<div class="management-icons">
			<a href="#" class="post-delete" title="<?php _e("Move card to trash"); ?>">
				<i class="dashicons dashicons-trash"></i>
			</a>
			<a href="#" class="post-update" title="<?php _e("Update card price"); ?>">
				<i class="dashicons dashicons-update"></i>
			</a>
			<a href="#" class="post-sell" title="<?php _e("Update card quantity based on new sales"); ?>">
				<i class="dashicons dashicons-tickets"></i>
			</a>
			<a href="#" class="post-info" title="<?php _e("Console log card information"); ?>">
				<i class="dashicons dashicons-info"></i>
			</a>
		</div>
	</td>
	<?php } ?>
</tr>
