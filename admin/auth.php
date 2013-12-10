<?php
	//Start session
	ob_start();
session_start();
if(!isset($_SESSION['admin-uid']) && !isset($_SESSION['admin-logged'])){
	$loc=urlencode($_SERVER['REQUEST_URI']);
header("Location: index?loc=$loc");
exit;
}



?>