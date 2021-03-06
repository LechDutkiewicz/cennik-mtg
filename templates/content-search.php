<?php use Roots\Sage\Utils; ?>
<?php $is_foil = get_post_meta($post->ID, 'foil'); ?>

<div class="row" data-foil="<?php if ( array_key_exists(0, $is_foil) && $is_foil[0] == 1 ) { echo 'yellow'; } else { echo "0"; } ?>" data-id="<?php echo $post->ID; ?>" data-table="<tr>">
	<div class="small-4 columns" data-table="<td>">
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
				<span data-tooltip aria-haspopup="true" class="has-tip" data-options="show_on:large" title="<?php echo get_post_meta($post->ID, 'uwagi')[0]; ?>" data-format-leave="0">
					<i class="dashicons dashicons-info"></i>
				</span>
				<?php } ?>
				<?php if ( $link = get_post_meta($post->ID, "link_do_karty") ) { ?>
				<a href="<?php echo $link[0]; ?>" class="dashicons dashicons-admin-links" title="Zobacz <?php the_title(); ?> na MKM" target="_blank" data-format-leave="0"></a>
				<a href="wp-admin/post.php?post=<?php echo $post->ID;?>&action=edit" class="dashicons dashicons-edit" data-format-leave="0"></a>
				<?php } ?>
			</div>
			<?php foreach ( Utils\get_meta_array() as $key => $name ) { ?>
			<div class="<?php echo $key; ?> small-<?php echo $key === "Edycja" ? "12" : "1"; ?> columns"<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?> data-<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>="<?php echo $name;?>"<?php } ?><?php if ( $key === "Ilość" || $key === "Sprzedane"|| $key === "Discount" || $key === "Własność" ) { ?> data-format-leave="0"<?php } else { ?>data-format-leave="1"<?php } ?> data-table="<td>">
				
				<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>
				
				<a href="#" class="dashicons-before dashicons-minus change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="-1" data-format-leave="0"></a>
				
				<?php } ?>

				<span><?php if ( $key === "Ilość" || $key === "Sprzedane" ) { ?><small><?php } ?><?php echo $name; ?><?php if ( $key === "Ilość" || $key === "Sprzedane" ) { ?></small><?php } ?></span>
				
				<?php if ( $key === "Ilość" || $key === "Sprzedane" && is_user_logged_in() ) { ?>
				
				<a href="#" class="dashicons-before dashicons-plus change-amount" data-change="<?php echo $key === "Ilość" ? "ilosc" : "sprzedane"; ?>" data-step="1" data-format-leave="0"></a>
				
				<?php } ?>
			</div>

			<?php if ( $key === "Sprzedane" && is_user_logged_in() ) { ?>

			<span class="hide sold-amount" data-format-leave="2" data-table="<td>"></span>

			<?php } ?>

			<?php if ( $key === "Edycja") { ?>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
	<?php if (is_user_logged_in()) { ?>
	<div class="small-1 columns" data-format-leave="0">
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
			<a href="#" class="post-hide" title="<?php _e("Remove from basket"); ?>">
				<i class="dashicons dashicons-no"></i>
			</a>
		</div>
	</div>
	<?php } ?>
	<div class="small-12 columns" data-format-leave="0">
		<div class="divider"></div>
	</div>
</div>
