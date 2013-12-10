<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['studentid']) && !empty($_POST['studentid'])){
	$status = $Wall->AddFriend($_POST['studentid'], $uid);
	echo $status;
}
?>