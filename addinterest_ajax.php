<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['name']) && !empty($_POST['name']) && !empty($uid)){
	$name = $Wall->interestadd(clean_data($uid), clean_data($_POST['name']));
	echo $name;
	
}
?>