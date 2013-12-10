<?php
$user = new User();
if(empty($_SESSION['uid']) && empty($_SESSION['type'])){header("Location: http://istudent.blakebytes.com.au/index.php");exit;}
elseif($user->uidcheck($_SESSION['uid']) == false){$user->logoff(); header("Location: http://istudent.blakebytes.com.au/index.php");exit;}
?>