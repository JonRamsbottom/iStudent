<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/session.php");
$user = new User();
$user->logoff();
$page = "logoff";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>Log Out | iStudent</title>
<?php include_once "html_includes/css.php" ?>
<?php include_once "html_includes/js.php" ?>
</head>

<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
		<div id="left">
			
		</div> <!-- left side-->
		<div id="content" class="content">
			<div class="item-info"><h1>Log Out Successful</h1>
			<p>You have been successfully logged out of iStudent. Please close this window for extra security.</p></div>
		<br />
<br />
<br />

			
			
		</div><!-- content-->
		
	</article>
    <?php include_once "html_includes/footer.php" ?></div>
</body>
</html>