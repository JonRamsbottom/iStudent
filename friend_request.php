<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/Wall.php");
$Wall = new Wall;
if($_GET['show'] == "true" && !empty($_GET['studentid'])){
	echo $Wall->FriendRequestCount(clean_data($_GET['studentid']));
}