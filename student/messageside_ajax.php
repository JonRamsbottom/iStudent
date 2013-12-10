<?php
include("../config/dbconfig.php");
include("../config/common.php");
include("../config/iStudentUSER.php");
include("../config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
$user = new User();
if(!empty($uid))
{
	$conversation_uid = clean_data($_POST['cid']);
	$top_c_id = clean_data($_POST['top']);
if(!empty($conversation_uid))
{include('conversation_load_single.php');}
include('conversation_load.php');
}
?>