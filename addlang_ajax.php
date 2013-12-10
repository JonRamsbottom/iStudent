<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['lang']) && !empty($_POST['lang']) && !empty($uid)){
	$lang = $Wall->langadd(clean_data($uid), clean_data($_POST['lang']));
	echo $lang;
	
}
?>