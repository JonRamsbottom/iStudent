<?php
//Common PHP functions for use with iStudent Website. Author: Blake Garrett (www.blakebytes.com.au)

function clean_data($input) {
	global $dbc;
    $input = trim(htmlentities(strip_tags($input,",")));
 
    if (get_magic_quotes_gpc())
        $input = stripslashes($input);
 
    $input = mysqli_real_escape_string($dbc, $input);
 
    return $input;
}
function inputcheck($text){
	$text = clean_data($text);
	if(!empty($text) && strlen($text) > 0){return true;}
	else{return false;}	
}
function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
function is_bot() {
    $spiders = array(
        "abot",
        "dbot",
        "ebot",
        "hbot",
        "kbot",
        "lbot",
        "mbot",
        "nbot",
        "obot",
        "pbot",
        "rbot",
        "sbot",
        "tbot",
        "vbot",
        "ybot",
        "zbot",
        "bot.",
        "bot/",
        "_bot",
        ".bot",
        "/bot",
        "-bot",
        ":bot",
        "(bot",
        "crawl",
        "slurp",
        "spider",
        "seek",
        "accoona",
        "acoon",
        "adressendeutschland",
        "ah-ha.com",
        "ahoy",
        "altavista",
        "ananzi",
        "anthill",
        "appie",
        "arachnophilia",
        "arale",
        "araneo",
        "aranha",
        "architext",
        "aretha",
        "arks",
        "asterias",
        "atlocal",
        "atn",
        "atomz",
        "augurfind",
        "backrub",
        "bannana_bot",
        "baypup",
        "bdfetch",
        "big brother",
        "biglotron",
        "bjaaland",
        "blackwidow",
        "blaiz",
        "blog",
        "blo.",
        "bloodhound",
        "boitho",
        "booch",
        "bradley",
        "butterfly",
        "calif",
        "cassandra",
        "ccubee",
        "cfetch",
        "charlotte",
        "churl",
        "cienciaficcion",
        "cmc",
        "collective",
        "comagent",
        "combine",
        "computingsite",
        "csci",
        "curl",
        "cusco",
        "daumoa",
        "deepindex",
        "delorie",
        "depspid",
        "deweb",
        "die blinde kuh",
        "digger",
        "ditto",
        "dmoz",
        "docomo",
        "download express",
        "dtaagent",
        "dwcp",
        "ebiness",
        "ebingbong",
        "e-collector",
        "ejupiter",
        "emacs-w3 search engine",
        "esther",
        "evliya celebi",
        "ezresult",
        "falcon",
        "felix ide",
        "ferret",
        "fetchrover",
        "fido",
        "findlinks",
        "fireball",
        "fish search",
        "fouineur",
        "funnelweb",
        "gazz",
        "gcreep",
        "genieknows",
        "getterroboplus",
        "geturl",
        "glx",
        "goforit",
        "golem",
        "grabber",
        "grapnel",
        "gralon",
        "griffon",
        "gromit",
        "grub",
        "gulliver",
        "hamahakki",
        "harvest",
        "havindex",
        "helix",
        "heritrix",
        "hku www octopus",
        "homerweb",
        "htdig",
        "html index",
        "html_analyzer",
        "htmlgobble",
        "hubater",
        "hyper-decontextualizer",
        "ia_archiver",
        "ibm_planetwide",
        "ichiro",
        "iconsurf",
        "iltrovatore",
        "image.kapsi.net",
        "imagelock",
        "incywincy",
        "indexer",
        "infobee",
        "informant",
        "ingrid",
        "inktomisearch.com",
        "inspector web",
        "intelliagent",
        "internet shinchakubin",
        "ip3000",
        "iron33",
        "israeli-search",
        "ivia",
        "jack",
        "jakarta",
        "javabee",
        "jetbot",
        "jumpstation",
        "katipo",
        "kdd-explorer",
        "kilroy",
        "knowledge",
        "kototoi",
        "kretrieve",
        "labelgrabber",
        "lachesis",
        "larbin",
        "legs",
        "libwww",
        "linkalarm",
        "link validator",
        "linkscan",
        "lockon",
        "lwp",
        "lycos",
        "magpie",
        "mantraagent",
        "mapoftheinternet",
        "marvin/",
        "mattie",
        "mediafox",
        "mediapartners",
        "mercator",
        "merzscope",
        "microsoft url control",
        "minirank",
        "miva",
        "mj12",
        "mnogosearch",
        "moget",
        "monster",
        "moose",
        "motor",
        "multitext",
        "muncher",
        "muscatferret",
        "mwd.search",
        "myweb",
        "najdi",
        "nameprotect",
        "nationaldirectory",
        "nazilla",
        "ncsa beta",
        "nec-meshexplorer",
        "nederland.zoek",
        "netcarta webmap engine",
        "netmechanic",
        "netresearchserver",
        "netscoop",
        "newscan-online",
        "nhse",
        "nokia6682/",
        "nomad",
        "noyona",
        "nutch",
        "nzexplorer",
        "objectssearch",
        "occam",
        "omni",
        "open text",
        "openfind",
        "openintelligencedata",
        "orb search",
        "osis-project",
        "pack rat",
        "pageboy",
        "pagebull",
        "page_verifier",
        "panscient",
        "parasite",
        "partnersite",
        "patric",
        "pear.",
        "pegasus",
        "peregrinator",
        "pgp key agent",
        "phantom",
        "phpdig",
        "picosearch",
        "piltdownman",
        "pimptrain",
        "pinpoint",
        "pioneer",
        "piranha",
        "plumtreewebaccessor",
        "pogodak",
        "poirot",
        "pompos",
        "poppelsdorf",
        "poppi",
        "popular iconoclast",
        "psycheclone",
        "publisher",
        "python",
        "rambler",
        "raven search",
        "roach",
        "road runner",
        "roadhouse",
        "robbie",
        "robofox",
        "robozilla",
        "rules",
        "salty",
        "sbider",
        "scooter",
        "scoutjet",
        "scrubby",
        "search.",
        "searchprocess",
        "semanticdiscovery",
        "senrigan",
        "sg-scout",
        "shai'hulud",
        "shark",
        "shopwiki",
        "sidewinder",
        "sift",
        "silk",
        "simmany",
        "site searcher",
        "site valet",
        "sitetech-rover",
        "skymob.com",
        "sleek",
        "smartwit",
        "sna-",
        "snappy",
        "snooper",
        "sohu",
        "speedfind",
        "sphere",
        "sphider",
        "spinner",
        "spyder",
        "steeler/",
        "suke",
        "suntek",
        "supersnooper",
        "surfnomore",
        "sven",
        "sygol",
        "szukacz",
        "tach black widow",
        "tarantula",
        "templeton",
        "/teoma",
        "t-h-u-n-d-e-r-s-t-o-n-e",
        "theophrastus",
        "titan",
        "titin",
        "tkwww",
        "toutatis",
        "t-rex",
        "tutorgig",
        "twiceler",
        "twisted",
        "ucsd",
        "udmsearch",
        "url check",
        "updated",
        "vagabondo",
        "valkyrie",
        "verticrawl",
        "victoria",
        "vision-search",
        "volcano",
        "voyager/",
        "voyager-hc",
        "w3c_validator",
        "w3m2",
        "w3mir",
        "walker",
        "wallpaper",
        "wanderer",
        "wauuu",
        "wavefire",
        "web core",
        "web hopper",
        "web wombat",
        "webbandit",
        "webcatcher",
        "webcopy",
        "webfoot",
        "weblayers",
        "weblinker",
        "weblog monitor",
        "webmirror",
        "webmonkey",
        "webquest",
        "webreaper",
        "websitepulse",
        "websnarf",
        "webstolperer",
        "webvac",
        "webwalk",
        "webwatch",
        "webwombat",
        "webzinger",
        "wget",
        "whizbang",
        "whowhere",
        "wild ferret",
        "worldlight",
        "wwwc",
        "wwwster",
        "xenu",
        "xget",
        "xift",
        "xirq",
        "yandex",
        "yanga",
        "yeti",
        "yodao",
        "zao/",
        "zippp",
        "zyborg",
		"Facebook",
        "...."
    );

    foreach($spiders as $spider) {
        if ( stripos($_SERVER['HTTP_USER_AGENT'], $spider) !== false ) return true;
    }
    return false;

}
function toolink($text){

        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4})',
        '<a href="mailto:\\1"  rel="nofollow">\\1</a>', $text);
        return $text;
}

function tolink($text){
$text = " ".$text;
if(preg_match('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?/', $text, $url)) {
	$text = preg_replace('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/','<a href="'.$url[0].'" target="_blank" rel="nofollow">'.$url[0].'</a>', $text);
}
else if(preg_match('(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',$text,$url)){
	$text = preg_replace('(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)','<a href="http://'.$url[0].'" target="_blank" rel="nofollow">'.$url[0].'</a>', $text);
}

if(preg_match('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4})', $text, $url)) {
$text = preg_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4})','<a href="mailto:'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
}
return $text;
}

function htmlcode($orimessage){
$message= $orimessage;

$s = array ("<", ">");
$z = array ("&lt;","&gt;");
$final = str_replace($s, $z, $message);

$message=tolink(trim(str_replace("\n", "<br/>", $final)));
return stripslashes($message);
}
function htmlcode_nolink($orimessage){
$message= preg_replace("/\r\n|\r|\n/", ' ', $orimessage);

$s = array ("<", ">");
$z = array ("&lt;","&gt;");
$final = str_replace($s, $z, $message);

return stripslashes($final);
}
function calcutateAge($dob){
		if(!empty($dob)){
        $dob = date("d/m/Y",strtotime($dob));

        $dobObject = new DateTime($dob);
        $nowObject = new DateTime();

        $diff = $dobObject->diff($nowObject);

        return $diff->y;}
		

}
function hitcounter($studentid, $page){
	global $dbc;
	include("geoip_api/geoip.inc"); //Opens GeoIP PHP API to track user IP address
$gi = geoip_open("config/GeoIP.dat",GEOIP_STANDARD);
$ip = get_client_ip();
$country = geoip_country_code_by_addr($gi, $ip);
geoip_close($gi);
if(is_bot() == false && filter_var($ip, FILTER_VALIDATE_IP) == true){
$time = time();

$strtotime = date("o-\WW");
$start = strtotime($strtotime);
$end = strtotime("+6 days 23:59:59", $start);
$exec = mysqli_query($dbc, "SELECT timestamp FROM viewtracker WHERE ipaddress='$ip' AND studentid='$studentid' AND timestamp>'$start' AND timestamp<'$end'LIMIT 1");
if(mysqli_num_rows($exec) == 0){
mysqli_query($dbc, "INSERT INTO viewtracker (`timestamp`, `ipaddress`, `country`, `studentid`, `pagetype`) VALUES ('$time', '$ip', '$country', '$studentid', '$page')");
}
}

}
function get_months($startstring, $endstring)
{
$time1  = strtotime($startstring);//absolute date comparison needs to be done here, because PHP doesn't do date comparisons
$time2  = strtotime($endstring);
$my1     = date('mY', $time1); //need these to compare dates at 'month' granularity
$my2    = date('mY', $time2);
$year1 = date('Y', $time1);
$year2 = date('Y', $time2);
$years = range($year1, $year2);
 
foreach($years as $year)
{
$months[$year] = array();
while($time1 < $time2)
{
if(date('Y',$time1) == $year)
{
$months[$year][] = date('m', $time1);
$time1 = strtotime(date('Y-m', $time1).' +1 month');
}
else
{
break;
}
}
continue;
}
 
return $months;
}

function weeksinmonth($month, $year) {
 // Start of month
 $start = mktime(0, 0, 0, $month, 1, $year);
 // End of month
 $end = mktime(0, 0, 0, $month, date('t', $start), $year);
 // Start week
 $start_week = date('W', $start);
 // End week
 $end_week = date('W', $end);
 
 if ($end_week < $start_week) { // Month wraps
   return ((52 + $end_week) - $start_week) + 1;
 }
 
 return ($end_week - $start_week) + 1;
}
function time_stamp($session_time) 
{ 
 
$time_difference = time() - $session_time ; 
$seconds = $time_difference ; 
$minutes = round($time_difference / 60 );
$hours = round($time_difference / 3600 ); 
$days = round($time_difference / 86400 ); 
$weeks = round($time_difference / 604800 ); 
$months = round($time_difference / 2419200 ); 
$years = round($time_difference / 29030400 ); 

if($seconds <= 60)
{
echo"a few seconds ago"; 
}
else if($minutes <=60)
{
   if($minutes==1)
   {
     echo"About a minute ago"; 
    }
   else
   {
   echo"$minutes minutes ago"; 
   }
}
else if($hours <=24)
{
   if($hours==1)
   {
   echo"About one hour ago";
   }
  else
  {
  echo"About $hours hours ago";
  }
}
else if($days <=7)
{
  if($days==1)
   {
   echo"one day ago";
   }
  else
  {
  echo"$days days ago";
  }


  
}
else if($weeks <=4)
{
  if($weeks==1)
   {
   echo"one week ago";
   }
  else
  {
  echo"$weeks weeks ago";
  }
 }
else if($months <=12)
{
   if($months==1)
   {
   echo"one month ago";
   }
  else
  {
  echo"$months months ago";
  }
 
   
}

else
{
if($years==1)
   {
   echo"one year ago";
   }
  else
  {
  echo"$years years ago";
  }


}
 


} 
?>