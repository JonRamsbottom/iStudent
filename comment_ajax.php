<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
$user = new User();

if(isset($_POST['comment']) && !empty($_POST['comment']) && !empty($uid) && !empty($_POST['msg_id']) && !empty($_POST['msg_id'])){
	$cdata = $Wall->Insert_Comment($uid, clean_data($_POST['msg_id']), clean_data($_POST['comment']));
	if(!empty($cdata)){include('html_comment.php');}

}
?>