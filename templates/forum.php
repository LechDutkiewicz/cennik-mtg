<?php

use Roots\Sage\CurrencyCalculator;

$is_foil = get_post_meta($post->ID, 'foil');
$foil = "";
if ( array_key_exists( 0, $is_foil ) ) {
	if ( $is_foil[0] == 1 ) {
		$foil = " FOIL";
	}
}
$card_discount = get_post_meta($post->ID, 'discount');
$discount = 1;
if ( array_key_exists( 0, $card_discount ) ) {
	if ( $card_discount[0] != 0 ) {
		$discount = 1-$card_discount[0];
	}
}
$lang = get_post_meta($post->ID, 'jezyk')[0];
?>
<?php 

$output = get_post_meta($post->ID, 'ilosc')[0];
$output .= "x [MTG]" . get_the_title() . "[/MTG] - ";
$output .= $lang !== "eng" ? "[i]" . $lang . "[/i] " : "";
$output .= get_post_meta($post->ID, 'edycja')[0] . $foil . " - ";
$output .= get_post_meta($post->ID, 'stan')[0] . " - ";
$output .= "[b]" . CurrencyCalculator\fmtMoney(get_post_meta($post->ID, 'cena')[0] * $discount) . " zł[/b]";
$output .= "\n";

echo $output;
