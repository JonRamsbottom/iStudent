<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['msg_id']) && !empty($uid) && $Wall->Like_Check($_POST['msg_id'], $uid) == true){
	$count = $Wall->Like($_POST['msg_id'], $uid);
	echo $count;
}

?>