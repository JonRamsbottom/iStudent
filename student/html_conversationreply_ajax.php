<?php
include("../config/dbconfig.php");
include("../config/common.php");
include("../config/iStudentUSER.php");
include("../config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
$user = new User();

if(isset($_POST['last_time']) && isset($_POST['c_id']) && !empty($uid) )
{	
$last = clean_data($_POST['last_time']);
$top_c_id = clean_data($_POST['c_id']);
include('html_ConversationReply.php');
}
?>