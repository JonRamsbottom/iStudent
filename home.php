<?php
session_start();
include("config/common.php");
if($_SESSION['type'] == 1){
	header("Location: student/home");
}
else if($_SESSION['type'] == 2){
	header("Location: education_provider/home");
}
else if($_SESSION['type'] == 3){
	header("Location: home_stay_family/home");
}
?>
