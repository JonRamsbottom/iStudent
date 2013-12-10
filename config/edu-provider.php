<?php
class EducationProvider{

public function getedu($eduid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT * FROM educationprovider WHERE id='$eduid' LIMIT 1");
	return mysqli_fetch_array($q);
	
}
public function checkedu($eduid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT id FROM educationprovider WHERE id='$eduid' LIMIT 1");
	return mysqli_num_rows($q);
}
public function likecount($eduid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT id FROM edulike WHERE eduid='$eduid'");
	return mysqli_num_rows($q);
	
}
public function likecheck($eduid, $uid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT id FROM edulike WHERE eduid='$eduid' AND userid='$uid'");
	return mysqli_num_rows($q);
	
}
public function likeinsert($eduid, $uid){
	global $dbc;
	mysqli_query($dbc, "INSERT INTO edulike (`userid`, `eduid`) VALUES ('$uid', '$eduid')");
	return self::likecount($eduid);
	
}
public function usergrid($eduid, $limit){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT profile_picture,firstname,lastname,dataid FROM students WHERE educationprovider='$eduid' ORDER BY RAND() LIMIT $limit");
	return $q;
}
public function photoget($eduid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT * FROM eduphotos WHERE eduid='$eduid'");
	return $q;
}
public function photocount($eduid){
	global $dbc;
	$q = mysqli_query($dbc, "SELECT photoid FROM eduphotos WHERE eduid='$eduid'");
	return mysqli_num_rows($q);
}

}
?>