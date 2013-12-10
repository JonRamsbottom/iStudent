<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/edu-provider.php");
$uid = $_SESSION['uid'];
$educlass = new EducationProvider();
if(isset($_POST['eduid']) && !empty($_POST['eduid']) && !empty($uid) && $educlass->likecheck(clean_data($_POST['eduid']), $uid) == 0){
	$status = $educlass->likeinsert(clean_data($_POST['eduid']), $uid);
	echo $status;
}
?>