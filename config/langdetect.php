<?php
session_start();
header('Cache-control: private'); // IE 6 FIX
include("../geoip_api/geoip.inc"); //Opens GeoIP PHP API to track user IP address
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country = geoip_country_code_by_addr($gi, $_SERVER["REMOTE_ADDR"]);
geoip_close($gi);

if(isSet($_GET['lang']))
{
$lang = $_GET['lang'];
$_SESSION['lang'] = $lang;
setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']) )
{
$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else if($country == "US"){
	$lang='us';
		}
else if($country == "JP"){
	$lang='jp';
	}
else
{
$lang = 'en';
}

switch ($lang) {
  case 'en':
  $lang_file = 'lang.english.php';
  break;

  case 'us':
  $lang_file = 'lang.japanese.php';
  break;

  case 'cn':
  $lang_file = 'lang.chinese.php';
  break;

  default:
  $lang_file = 'lang.english.php';

}

include_once 'languages/'.$lang_file;
?>