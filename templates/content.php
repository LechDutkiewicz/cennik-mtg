<?php

use Roots\Sage\Utils;
$is_foil = get_post_meta($post->ID, 'foil');

if ( $is_foil ) {
	$is_foil = $is_foil[0];
}


/*====================================
=            Setup danych            =
====================================*/

// setup edycji
$edycja = get_post_meta($post->ID, "edycja");

if ( $edycja ) {
	$edycja = $edycja[0];
}

$stan = get_post_meta($post->ID, "stan");

if ( $stan ) {
	$stan = $stan[0];
}

$jezyk = get_post_meta($post->ID, "jezyk");

if ( $jezyk ) {
	$jezyk = $jezyk[0];
}


// setup ceny kompatybilny wstecz
$cena = get_post_meta($post->ID, "cena");

if ( $cena ) {
	if ( is_array($cena[0]) && array_key_exists("price_pln", $cena[0]) ) {
		$cena = $cena[0]["price_pln"];
	} else {
		$cena = $cena[0];
	}
} else {
	$cena = __("Undefined");
}

// setup ilości dostępnych
$ilosc = get_post_meta($post->ID, "ilosc");

if ( $ilosc ) {
	$ilosc = $ilosc[0];
}

/*=====  End of Setup danych  ======*/



?>

<div class="card small-12 medium-6 large-3 columns" data-foil="<?php if ( $is_foil == 1 ) { echo 'yellow'; } else { echo "0"; } ?>" data-id="<?php echo $post->ID; ?>">
	<div class="card__header">
		<img src='<?php echo get_post_meta($post->ID, 'img_link')[0]; ?>'>
		<div class="card__base--info">
			<div class="row">
				<div class="small-12 columns">
					<h5 class="card__name"><?php
					if ($is_foil) {
						echo "[FOIL]&nbsp;";
					}
					the_title();
					?></h5>
					<h6 class=""><?= $edycja; ?></h6>
				</div>
				<div class="small-12 columns">
					<div class="row">
						<div class="Cena small-6 columns">
							<span><?= $cena; ?></span>&nbsp;zł
						</div>
						<div class="Ilość small-6 columns" data-ilosc="<?= $ilosc; ?>">
							<?php
							if (is_user_logged_in()) {
								?>
								<a href="#" class="change-amount" data-change="ilosc" data-step="-1"><i class="dashicons dashicons-minus text-alert"></i></a>
								<?php
							}
							?>
							<span><?= $ilosc; ?></span>&nbsp;szt
							<?php
							if (is_user_logged_in()) {
								?>
								<a href="#" class="change-amount" data-change="ilosc" data-step="1"><i class="dashicons dashicons-plus text-success"></i></a>
								<?php
							}
							?>
						</div>
						<div class="<?php if (is_user_logged_in()) { echo "Stan "; } ?>small-6 columns">
							<span>Stan: <?= $stan; ?></span>
						</div>
						<div class="<?php if (is_user_logged_in()) { echo "Język "; } ?>small-6 columns">
							<span>Język: <?= $jezyk; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		if (is_user_logged_in()) {
			?>
			<div class="card__handy--icons">
				<?php
				if ( $link = get_post_meta($post->ID, "link_do_karty") ) {
					?>
					<a href="<?php echo $link[0]; ?>" class="" title="Zobacz <?php the_title(); ?> na MKM" target="_blank">
						<i class="dashicons dashicons-admin-links text-success"></i>
					</a>
					<a href="wp-admin/post.php?post=<?php echo $post->ID;?>&action=edit" class="">
						<i class="dashicons dashicons-edit text-warning"></i>
					</a>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	if (is_user_logged_in()) {
		?>
		<div class="row">
			<div class="small-12 columns">
				<div class="management-icons">
					<a href="#" class="post-delete" title="<?php _e("Move card to trash", "sage"); ?>">
						<i class="dashicons dashicons-trash"></i>
					</a>
					<a href="#" class="post-freeze" title="<?php _e("Freeze card price", "sage"); ?>">
						<?php if ( get_field("price_frozen") ) { ?>
						<i class="dashicons dashicons-lock text-alert"></i>
						<i class="dashicons dashicons-unlock text-success hide"></i>
						<?php } else { ?>
						<i class="dashicons dashicons-lock text-alert hide"></i>
						<i class="dashicons dashicons-unlock text-success"></i>
						<?php } ?>
					</a>
					<a href="#" class="post-update" title="<?php _e("Update card price", "sage"); ?>">
						<i class="dashicons dashicons-update dashicons-x2 text-primary"></i>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>

