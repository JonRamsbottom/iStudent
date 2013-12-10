<?php
include("dbconfig.php");
ob_start();
session_start();
if(isset($_SESSION['admin-uid']) && isset($_SESSION['admin-logged'])){
header("Location: tasks");
}
else{
if (isset($_POST['formsubmitted'])) {
 $error = "";

 if (empty($_POST['e-mail'])) {
 $error.= 'Please Enter your Email <br />';
 } else {

 if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['e-mail'])) {
 $Email = mysqli_real_escape_string($dbc, $_POST['e-mail']);
 } else {
 $error.= 'Your E-mail Address is invalid <br />';
 }
}

if (empty($_POST['Password'])) {
 $error.= 'Please Enter Your Password <br />';
 } else {
 $Password = $_POST['Password'];
 }


 if(empty($error)){
$query_check_credentials = "SELECT * FROM adminusers WHERE (email='$Email') AND active!='N'";
$result_check_credentials = mysqli_query($dbc, $query_check_credentials);


 if (@mysqli_num_rows($result_check_credentials)  < 1)
 { 
 
 $_SESSION['error'] = "Username/Password incorrect";
 header("Location: index");
 exit;
 }
$userdata = mysqli_fetch_array($result_check_credentials);
$hash = hash('sha256', $userdata['salt'] . hash('sha256', $Password) );
if($hash !== $userdata['password']){
$_SESSION['error'] = "Username/Password incorrect";
 header("Location: index");
 exit;
 
}
 
$_SESSION['admin-uid'] = $userdata['userid'];
$_SESSION['admin-logged'] = 1;
if(!empty($_GET['loc'])){
	$loc = urldecode($_GET['loc']);
 header("Location: $loc"); }
 else{
	 header("Location: tasks");}
 
 
}
else{
	$_SESSION['error'] = $error;
 header("Location: index");
 exit;}

}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login | iStudent Admin</title>

    <?php include_once "html_includes/css.php" ?>
</head>

<body>
<div id="wrap">
<div id="bodyWrapper" class="main_bg">
    <div id="header">
      <div class="fix_width">
            <div class="fl logo" ><a href="tasks"><img src="imagesnew/logo.png" width="231" height="38" alt="iStudent" /></a></div>
            <div class="fl head_top">
                
 




      </div>
        </div>
    </div>   
    <div id="home_inner_middle">
        <div class="fix_width">
        	<div class="breadcrumbs">
            	<ul>
                	<li><a href="index" title="Login">Login</a></li>
                   
                </ul>
            </div>
            <div class="cl"></div>
            <h1>Login</h1>
            <div class="contact_lft"> <p>
            
            <form action="" method="post" name="loginForm" id="loginForm"> 
    <p>Enter your username and password below to login:<br />
    </p>
    <table width="600" border="0">
      <tr>
        <td width="110"><strong>Email:</strong></td>
        <td width="480"><input name="e-mail" type="text" id="e-mail" value="<?php echo $_POST['e-mail'] ?>" size="25" /></td>
      </tr>
      <tr>
        <td><strong>Password:</strong></td>
        <td><input name="Password" type="password" id="Password" value="<?php echo $_POST['Password'] ?>" size="25" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="formsubmitted" value="TRUE" /></td>
        <td><input type="submit" value="Login" /></td>
      </tr>
    </table><br />

    <span class="error"><?php echo $_SESSION['error'];  unset($_SESSION['error']); ?></span>
    </form>
            </p>
                            
             

            </div>
        </div>
    </div>
    <div class="cl"></div>
 </div></div>   
    
    <?php include_once "html_includes/footer.php" ?>
</body>
</html>
