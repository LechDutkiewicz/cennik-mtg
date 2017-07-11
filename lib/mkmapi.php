<?php

require_once 'currency-calculator.php';

use Roots\Sage\CurrencyCalculator;

function MKM_API( $data, $is_foil = null ) {

  if ( get_post_status($data) ) {
    $card_title = get_the_title($data);
  } else if ( is_integer($data) ) {
    $api_url = "https://www.mkmapi.eu/ws/v1.1/product/" . $data;
  } else {
    $card_title = $data;
  }
/**
    * Declare and assign all needed variables for the request and the header
    *
    * @var $method string Request method
    * @var $url string Full request URI
    * @var $appToken string App token found at the profile page
    * @var $appSecret string App secret found at the profile page
    * @var $accessToken string Access token found at the profile page (or retrieved from the /access request)
    * @var $accessSecret string Access token secret found at the profile page (or retrieved from the /access request)
    * @var $nonce string Custom made unique string, you can use uniqid() for this
    * @var $timestamp string Actual UNIX time stamp, you can use time() for this
    * @var $signatureMethod string Cryptographic hash function used for signing the base string with the signature, always HMAC-SHA1
    * @var version string OAuth version, currently 1.0
    */

$method             = "GET";
$url                = isset( $api_url ) ? $api_url : "https://www.mkmapi.eu/ws/v1.1/products/" . standarize_card_name( $card_title ) . "/1/1/true";

// $url                = "https://www.mkmapi.eu/ws/v1.1/" . get_field("edycja", $data) . "/1/" . get_the_title($data);
// $appToken           = "l72p6jX7eWUvIKgK";
// $appSecret          = "KkudGqMxpwlWojpAbW2bVtRWMj9XTFyk";
// $accessToken        = "HISmnZ3fn4VZWpN2QDUxQHaeySfYivcZ";
// $accessSecret       = "Li20lTmHJaBPUFvCIPM0rHXBAoEr7nKm";

// $appToken           = "gpkdJkgxC89CAGZr";
// $appSecret          = "7FBV8MSZ3AnfN7PdVCWhlyeti3eexepK";
// $accessToken        = "yxS0RkdYEmI3as035ZrmVJo6ShyLk4ZT";
// $accessSecret       = "HHWGBpEnTsKsc4hJrmoBHgKjQwEdaebF";

// $appToken           = "FavKlMtxq6Ud02lW";
// $appSecret          = "eBjJf6VHa6MglHx4wAKWmJk3e8etJ3C4";
// $accessToken        = "plE39yzWe0by8tLZ4sUF8bzSrekaT8az";
// $accessSecret       = "FmSjDUjT1J8clTRBmRxQJtCqzm7VapfP";

$appToken           = "2AoMhbIlzAmymiVY";
$appSecret          = "DRvyhDFFpsWrobtkkdNqrAAfl5QUMkfc";
$accessToken        = "MAH0bnWObwz1Tq8eHXtWKk9bTq4Lpxxj";
$accessSecret       = "DgxM1AsoCSEm848oHAlBRz1y2Ffm3SQG";

$nonce              = uniqid();
// $timestamp          = "1407917892";
$timestamp          = time();
$signatureMethod    = "HMAC-SHA1";
$version            = "1.0";

   /**
    * Gather all parameters that need to be included in the Authorization header and are know yet
    *
    * @var $params array|string[] Associative array of all needed authorization header parameters
    */
   $params             = array(
   	'realm'                     => $url,
   	'oauth_consumer_key'        => $appToken,
   	'oauth_token'               => $accessToken,
   	'oauth_nonce'               => $nonce,
   	'oauth_timestamp'           => $timestamp,
   	'oauth_signature_method'    => $signatureMethod,
   	'oauth_version'             => $version,
   	);
   
   /**
    * Start composing the base string from the method and request URI
    *
    * @var $baseString string Finally the encoded base string for that request, that needs to be signed
    */
   $baseString         = strtoupper($method) . "&";
   $baseString        .= rawurlencode($url) . "&";
   
   /*
    * Gather, encode, and sort the base string parameters
    */
   $encodedParams      = array();
   foreach ($params as $key => $value)
   {
   	if ("realm" != $key)
   	{
   		$encodedParams[rawurlencode($key)] = rawurlencode($value);
   	}
   }
   ksort($encodedParams);
   
   /*
    * Expand the base string by the encoded parameter=value pairs
    */
   $values             = array();
   foreach ($encodedParams as $key => $value)
   {
   	$values[] = $key . "=" . $value;
   }
   $paramsString       = rawurlencode(implode("&", $values));
   $baseString        .= $paramsString;
   
   /*
    * Create the signingKey
    */
   $signatureKey       = rawurlencode($appSecret) . "&" . rawurlencode($accessSecret);
   
   /**
    * Create the OAuth signature
    * Attention: Make sure to provide the binary data to the Base64 encoder
    *
    * @var $oAuthSignature string OAuth signature value
    */
   $rawSignature       = hash_hmac("sha1", $baseString, $signatureKey, true);
   $oAuthSignature     = base64_encode($rawSignature);
   
   /*
    * Include the OAuth signature parameter in the header parameters array
    */
   $params['oauth_signature'] = $oAuthSignature;
   
   /*
    * Construct the header string
    */
   $header             = "Authorization: OAuth ";
   $headerParams       = array();
   foreach ($params as $key => $value)
   {
   	$headerParams[] = $key . "=\"" . $value . "\"";
   }
   $header            .= implode(", ", $headerParams);
   
   /*
    * Get the cURL handler from the library function
    */
   $curlHandle         = curl_init();
   
   /*
    * Set the required cURL options to successfully fire a request to MKM's API
    *
    * For more information about cURL options refer to PHP's cURL manual:
    * http://php.net/manual/en/function.curl-setopt.php
    */
   curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curlHandle, CURLOPT_URL, $url);
   curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
   curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
   
   /**
    * Execute the request, retrieve information about the request and response, and close the connection
    *
    * @var $content string Response to the request
    * @var $info array Array with information about the last request on the $curlHandle
    */
   $content            = curl_exec($curlHandle);
   $info               = curl_getinfo($curlHandle);

   if(!curl_exec($curlHandle)){
   	die('Error: "' . curl_error($curlHandle) . '" - Code: ' . curl_errno($curlHandle));
   }

   curl_close($curlHandle);
   
   /*
    * Convert the response string into an object
    *
    * If you have chosen XML as response format (which is standard) use simplexml_load_string
    * If you have chosen JSON as response format use json_decode
    *
    * @var $decoded \SimpleXMLElement|\stdClass Converted Object (XML|JSON)
    */
   // $decoded            = json_decode($content);
   $decoded            = simplexml_load_string($content);

   return $decoded;

  // return standarize_card_name( get_the_title($data) );

 }

 function MKM_update_card( $post_id, $is_foil = null, $product_id = null ) {

   $card_data = array(
    "price"     => "",
    "rarity"    => "",
    "img"       => "",
    "mkm_link"  =>""
    );

   if ( !$product_id ) {
    $card_data["edycja"] = get_post_meta($post_id, 'edycja')[0];
    $card_id = $post_id;
  } else {
    $card_id = (int) $product_id;
  }

  foreach ($decoded = MKM_API( $card_id, $is_foil ) as $card) {
    if ( ( array_key_exists("edycja", $card_data) && $card->expansion == $card_data["edycja"] ) || $product_id ) {
      $card_data["price"] = $is_foil ? (string) $card->priceGuide->LOWFOIL : (string) $card->priceGuide->TREND;
      $card_data["rarity"] = (string) $card->rarity;
      $card_data["img"] = (string) $card->image;
      $card_data["mkm_link"] = (string) $card->website;
    }

    $cena = new CurrencyCalculator\ForeignExchange("EUR", "PLN");

    $price = CurrencyCalculator\fmtMoney($cena->toForeign($card_data["price"]));

    update_field("cena", $price, $post_id);
    update_field("rarity", standarize_rarity( $card_data["rarity"] ), $post_id);
    update_field("img_link", "https://www.magiccardmarket.eu" . str_replace("./", "/", $card_data["img"]), $post_id);
    update_field("link_do_karty", "https://www.magiccardmarket.eu" . str_replace("./", "/", $card_data["mkm_link"]), $post_id);

    $card_name = standarize_card_name( get_the_title($post_id) );

  }

  $output = array(
    "price"       => $price,
    "input_data"  => $card_id,
    "is_foil"     => $is_foil,
    );

  return $output["price"];

}

 function MKM_update_price( $post_id, $is_foil = null, $product_id = null ) {

   $card_data = array(
    "price"     => "",
    );

   if ( !$product_id ) {
    $card_data["edycja"] = get_post_meta($post_id, 'edycja')[0];
    $card_id = $post_id;
  } else {
    $card_id = (int) $product_id;
  }

  foreach ($decoded = MKM_API( $card_id, $is_foil ) as $card) {
    if ( ( array_key_exists("edycja", $card_data) && $card->expansion == $card_data["edycja"] ) || $product_id ) {
      $card_data["price"] = $is_foil ? (string) $card->priceGuide->LOWFOIL : (string) $card->priceGuide->TREND;
    }

    $cena = new CurrencyCalculator\ForeignExchange("EUR", "PLN");

    $price = CurrencyCalculator\fmtMoney($cena->toForeign($card_data["price"]));

    // update_field("cena", $price, $post_id);
    update_post_meta($post_id, "cena", $price);

    $card_name = standarize_card_name( get_the_title($post_id) );

  }

  $output = array(
    "price"       => $price,
    "input_data"  => $card_id,
    "is_foil"     => $is_foil,
    "card_name"   => $card_name,
    "expansion"   => $card_data["edycja"]
    );

  return $output["price"];

}

function standarize_card_name( $data ) {

  $output = str_replace(",", "%2C", $data);
  $output = str_replace("'", "%27", $output);
  $output = str_replace("&#8217;", "%27", $output);
  $output = str_replace("/", "%2F", $output);
  $output = str_replace("&", "%26", $output);
  $output = str_replace(":", "%3A", $output);
  $output = str_replace(" ", "+", $output);
  $output = str_replace(")", "%29", $output);
  $output = str_replace("(", "%28", $output);

    return $output;

  }

  function standarize_rarity( $data ) {

    switch ($data) {
      case 'Mythic':
      $output = 1;
      break;

      case 'Rare':
      $output = 2;
      break;

      case 'Uncommon':
      $output = 3;
      break;

      case 'Common':
      $output = 4;
      break;

      case 'Land':
      $output = 6;
      break;

      default:
      $output = 5;
      break;
    }

    return $output;

  }

  ?>