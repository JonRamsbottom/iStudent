<?php
include("auth.php");
include("dbconfig.php");
include("common.php");

if (isset($_POST['password-change'])) {
		if ($_POST['password'] !== $_POST['password2']){
			$_SESSION['error1'] = "Passwords do not match!";
		header("Location: pwdchange");
		exit;
		
			
		}
		elseif ($_POST['password'] == ''){
			$_SESSION['error1'] = "Password cannot be blank!";
		header("Location: pwdchange");
		exit;
			
		}
		else{
			$password = $_POST['password'];
			$hash = hash('sha256', $password);
$salt = createSalt();
$hash = hash('sha256', $salt . $hash);
			$id = $_SESSION['admin-uid'];
			$query = "UPDATE `adminusers` SET `password` = '$hash', `salt`='$salt' WHERE `userid` = '$id' LIMIT 1";
	$exec = mysqli_query($dbc, $query);
		$_SESSION['error1'] = "Password changed successfully!";
		header("Location: pwdchange");
		exit;
		}
		
		
		
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Password | iStudent Admin</title>

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
            <h1>Change Password</h1>
            <div class="contact_lft"> Use the fields to enter your new password, then click the 'Submit' button.
              <br />
              <br />
              <form method="post" action="">
              <table width="466" border="0" cellspacing="10">
                <tr>
                  <td width="179">New Password:</td>
                  <td width="237"><label for="password"></label>
                  <input type="password" name="password" id="password" /></td>
                </tr>
                <tr>
                  <td>Confirm New Password:</td>
                  <td><label for="password2"></label>
                  <input type="password" name="password2" id="password2" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                </tr><input type="hidden" value="TRUE" name="password-change" />
              </table></form>
              <div class='error'> <?php  session_start(); echo $_SESSION['error1'];  unset($_SESSION['error1']); ?></div>
            </div>
        </div>
    </div>
    <div class="cl"></div>
 </div></div>   
    
    <?php include_once "html_includes/footer.php" ?>
</body>
</html>
