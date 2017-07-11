<?php use Roots\Sage\Utils; ?>

<div class="container">
	<div class="row">
		<!-- <div class="small-9 columns">
			<form id="card-list" action="javascript:alert( 'success!' );">				
				<label for="list">
					<textarea name="list" rows="10"></textarea>
				</label>
				<input class="button" name="submit" id="submit" type="submit" value="Dodaj">
			</form>
		</div>
		<div class="small-3 columns">
			<div class="msg-container"></div>
			<div class="loading">
				<svg width='120px' height='120px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-clock"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="30" fill="#d6f1ff" stroke="#2b74ba" stroke-width="8px"></circle><line x1="50" y1="50" x2="50" y2="30" stroke="#000000" stroke-width="5" stroke-linecap="round"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="5s" repeatCount="indefinite"></animateTransform></line><line x1="50" y1="50" x2="50" y2="20" stroke="#f00" stroke-width="2px" stroke-linecap="round" opacity="0"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="1s" repeatCount="indefinite"></animateTransform></line></svg>
			</div>
		</div> -->
		<div class="small-12 columns">
			<form id="add-card" action="javascript:alert( 'success!' );">
				<div class="row">
					<div class="small-2 columns">
						<label for="name"><?php _e("Card name"); ?></label>
						<input name="name" id="name" type="text">
					</div>
					<div class="small-2 columns">
						<label for="expansion"><?php _e("Card expansion"); ?></label>
						<select name="expansion" id="expansion"></select>
						<input type="hidden" id="id">
					</div>
					<div class="small-2 columns">
						<label for="condition"><?php _e("Card condition"); ?></label>
						<select name="condition" id="condition">
							<?php foreach ( Utils\get_conditions_array() as $key => $value ) { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="small-2 columns">
						<label for="language"><?php _e("Card language"); ?></label>
						<select name="language" id="language">
							<?php foreach ( Utils\get_languages_array() as $key => $value ) { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="small-2 columns end">
						<label for="quantity"><?php _e("Card quantity"); ?></label>
						<input name="quantity" type="number" value="1" step="1">
					</div>
				</div>
				<div class="row">
					<div class="small-2 columns">
						<label for="comments"><?php _e("Comments"); ?></label>
						<input name="comments" type="text">
					</div>
					<div class="small-2 columns">
						<div class="row">
							<div class="small-12 colums">
								<input name="foil" id="regular" type="radio" value="0" checked="checked">
								<label for="regular"><?php _e("Regular"); ?></label>
							</div>
							<div class="small-12 colums">
								<input name="foil" id="foil" type="radio" value="1">
								<label for="foil"><?php _e("Foil"); ?></label>
							</div>
						</div>
					</div>
					<div class="small-2 columns">
						<label for="owner"><?php _e("Card owner"); ?></label>
						<select name="owner" id="owner">
							<?php foreach ( Utils\get_owners_array() as $key => $value ) { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="small-2 columns">
						<input class="button" type="submit" value="<?php _e("Add card"); ?>">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>