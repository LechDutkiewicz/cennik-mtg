<?php

namespace Roots\Sage\CurrencyCalculator;

// fx.php - PHP Code to convert currencies using Yahoo's currency conversion service.
// by Adam Pierce <adam@doctort.org> 22-Oct-2008
// This code is public domain.

class ForeignExchange
{
	private $fxRate;
	
	public function __construct($currencyBase, $currencyForeign)
	{
		$url = 'http://download.finance.yahoo.com/d/quotes.csv?s='
		.$currencyBase .$currencyForeign .'=X&f=l1';

		$c = curl_init($url);
		curl_setopt($c, CURLOPT_HEADER, 0);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$this->fxRate = doubleval(curl_exec($c));
		curl_close($c);
	}

	public function toBase($amount)
	{
		if($this->fxRate == 0)
			return 0;

		return  $amount / $this->fxRate;
	}
	
	public function toForeign($amount)
	{
		if($this->fxRate == 0)
			return 0;

		return $amount * $this->fxRate;
	}
};

/* Zwiększenie ceny do liczby całkowitej, minimalna cena 1 pln */


function fmtMoney($amount)
{
	if ( $amount < 1 ) {
		return 1;
	} else {
		return round($amount, 0, PHP_ROUND_HALF_UP);
	}
}

function convertCurrency($amount) {

	$url = "http://finance.google.com/finance/converter?a=$amount&from=EUR&to=PLN";
    // Previously: $url = "http://www.google.com/finance/converter?a=1&from=GBP&to=$to";
	$request = curl_init();
	$timeOut = 0;
	curl_setopt ($request, CURLOPT_URL, $url);
	curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
	curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
	$response = curl_exec($request);
	curl_close($request);

	$regularExpression = '#\<span class=bld\>(.+?)\<\/span\>#s';
	preg_match($regularExpression, $response, $finalData);
	$rate = $finalData[0];
	$rate = strip_tags($rate);
	$rate = substr($rate, 0, -4);

	$price_pln = round($rate, 0, PHP_ROUND_HALF_UP);

	if ( $price_pln < 1 ) {
		return 1;
	} else {
		return $price_pln;
	}
}

?>