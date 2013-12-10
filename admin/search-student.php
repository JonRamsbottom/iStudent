<?php
include("auth.php");
include("dbconfig.php");
include("common.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Students | iStudent Admin</title>

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
            <h1>Search & Edit Students</h1>
            <div class="contact_lft"> Use the fields below to search for students on the iStudent site.
              <br />
              <br />
              
              
            </div>
        </div>
    </div>
    <div class="cl"></div>
 </div></div>   
    
    <?php include_once "html_includes/footer.php" ?>
</body>
</html>
