<?php
function getuserdata($uid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT * FROM adminusers WHERE userid='$uid' LIMIT 1");
	return mysqli_fetch_array($q);
}
function clean_data($input) {
	global $dbc;
    $input = trim(htmlentities(strip_tags($input,",")));
 
    if (get_magic_quotes_gpc())
        $input = stripslashes($input);
 
    $input = mysqli_real_escape_string($dbc, $input);
 
    return $input;
}
function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}
function studentcount(){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT usernum FROM users WHERE active=1 AND usertype=1");
	return mysqli_num_rows($q);
}
function educount(){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT id FROM educationprovider");
	return mysqli_num_rows($q);
}
function facebookcount(){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT usernum FROM users WHERE active=1 AND usertype=1 AND facebook_id!=''");
	return mysqli_num_rows($q);
}
function homestaycount(){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT familyid FROM homestaylist");
	return mysqli_num_rows($q);
}
?>