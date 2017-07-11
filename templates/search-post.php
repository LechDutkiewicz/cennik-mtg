<?php
use Roots\Sage\Utils; 
$meta_array = Utils\get_meta_headers();
?>
<?php get_template_part("templates/searchform"); ?>
<div class="row">
	<div class="content small-12 columns" data-table="<table>">
		<div class="row" data-table="<tr>">
			<div class="small-4 columns" data-table="<th>">
				<div class="row">
					<div class="small-12 columns" data-format-leave="1">
						<span>Nazwa karty</span>
					</div>
					<?php foreach ( $meta_array as $meta_key => $visibility ) { ?>
					<div class="small-<?php echo $meta_key === "Edycja" ? "12" : "1"; ?> columns" data-format-leave="<?php echo $visibility; ?>" data-table="<th>">
						<span><?php echo $meta_key; ?></span>
					</div>
					<?php if ( $meta_key === "Edycja" ) { ?>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
			<?php if (is_user_logged_in()) { ?><div class="small-1 columns" data-format-leave="0" data-table="<th>">Akcje</div><?php } ?>
		</div>
		<hr data-format-leave="0" >
		<div class="row" data-table="<tbody>">
			<div class="small-12 columns cards-list" data-format-leave="3"></div>
		</div>
		<div class="row" data-table="<tbody>">
			<div class="margin-top order-sum" data-table="<tr>">
				<div class="small-3 columns" data-format-leave="0"><span class="label">Team:</span> <span class="sum-price" data-owner="Team"></span></div>
				<div class="small-3 columns" data-format-leave="0"><span class="label">Leszek:</span> <span class="sum-price" data-owner="Leszek"></span></div>
				<div class="small-3 columns" data-format-leave="0"><span class="label">Sławek:</span> <span class="sum-price" data-owner="Sławek"></span></div>
				<div class="hide" data-format-leave="2" data-table="<td>"></div>
				<div class="hide" data-format-leave="2" data-table="<td>"></div>
				<div class="hide" data-format-leave="2" data-table="<td>"></div>
				<div class="hide" data-format-leave="2" data-table="<td>"></div>
				<div class="small-3 columns" data-table="<td>"><span class="label alert">Total:</span> <span class="sum-price" data-owner="total"></span></div>
				<div class="hide" data-format-leave="2" data-table="<td>"><span>+ 6 zł KP</span></div>
			</div>
		</div>
		<div class="row" data-format-leave="0">
			<div class="margin-top">
				<div class="small-3 columns">
					<button id="format-basket" class="small secondary">Formatuj do maila</button>
				</div>
			</div>
		</div>
	</div>
</div>