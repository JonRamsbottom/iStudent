<?php
include("auth.php");
include("dbconfig.php");
include("common.php");
$uid = clean_data($_SESSION['admin-uid']);
$data = getuserdata($uid);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home | iStudent Admin</title>

    <?php include_once "html_includes/css.php" ?>
</head>

<body>
<div id="wrap">
<div id="bodyWrapper" class="main_bg">
    <div id="header">
      <div class="fix_width">
            <div class="fl logo" ><a href="tasks"><img src="imagesnew/logo.png" width="231" height="38" alt="iStudent" /></a></div>
            <div class="fl head_top">
                
 

    <?php include_once "html_includes/menu.php" ?>



      </div>
        </div>
    </div>   
    <div id="home_inner_middle">
        <div class="fix_width">
        	<div class="breadcrumbs">
            	<ul>
                	<li><a href="index" title="Login">Home</a></li>
                   
                </ul>
            </div>
            <div class="cl"></div>
            <h1>iStudent Administration Console</h1>
            <div class="contact_lft"> <p>Hi <?php echo $data['fname']; ?>,<br />
              <br />
            This is the iStudent Administration Console where you can monitor and administer the iStudent Webiste.</p>
              <p>&nbsp;</p>
              <p><strong>Quick Overview:</strong></p>
              Active Students Registered: <strong><?php echo studentcount(); ?></strong><br />
              Students using Facebook Login: <strong><?php echo facebookcount(); ?></strong><br />
              Education Providers Registered: <strong><?php echo educount(); ?></strong><br />
              Home Stay Families Registered: <strong><?php echo homestaycount(); ?></strong>
            </div>
        </div>
    </div>
    <div class="cl"></div>
 </div></div>   
    
    <?php include_once "html_includes/footer.php" ?>
</body>
</html>
