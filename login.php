<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
$page = "login";
$user = new User();
if(isset($_POST['login-submit'])){
	if($_SESSION['login-checksum'] == $_POST['login-checksum']){
		if(inputcheck($_POST['email']) && inputcheck($_POST['password'])){
			$userdata = $user->userlogin($_POST['email'], $_POST['password']);
			if($userdata != false){
				$usernum = $userdata[0]; $type = $userdata[1];
				$user->sessionadd($usernum, $type);
				header("Location: home");
			    exit;
				}
			else{$error= "Username/Password incorrect. Please try again.";}}
			
						
		
		else{$error = "Please ensure all fields are completed.";}
		
	}
	else{$error="An error occured. Please try again.";}
	
	header("Location: login");
	$_SESSION['login-error'] = $error;
	exit;
	}
$_SESSION['login-checksum'] = sha1(microtime());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link href="/css/jquery.bxslider.css" rel="stylesheet" />
<?php include_once "html_includes/js.php" ?>
<script src="/js/jquery.bxslider.min.js"></script>
<script src="/js/gen_validatorv4.js"></script>


    
    <script type="text/javascript">
$(document).ready(function(){
  $('.bxslider').bxSlider({
onSliderLoad: function(){
        $(".slide").css("visibility", "visible");
      },
  auto: true,
  autoControls: true,
});
	

});
    </script>
</head>

<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<div class="containerer">	
		                <form id="login" name="login" action="" method="post">

        <div class="kontener100">
        <div id="reglog">
        	<h1>Log In to iStudent</h1>
            <a href="login-facebook"><button type="button" class="facebtn"><i class="faceico"></i><b>Log in with Facebook</b></button></a>
            <div class="or"></div>
            <div class="cont372"><input type="email" name="email" placeholder="Email Address"><i class="emailico"></i></div>
            <div class="cont372"><input type="password" name="password" placeholder="Password"><i class="passico"></i></div>
        <input name="remember" type="checkbox">Keep me signed in <div class="showmore right">Forgot Password?</div><br /><br />

<span class='error' style="font-size:12px; color:#F00">
        <?php session_start(); echo $_SESSION['login-error'];  unset($_SESSION['login-error']); ?>
        </span>
        <button class="logbtn"><b>Log In</b></button> <input type="hidden" name="login-submit" value="TRUE" /> <input type="hidden" name="login-checksum" value="<?php echo $_SESSION['login-checksum']; ?>" /> 
        <h5>Don't have an account?<a href="index"><div class="showmore" style="display:inline-block; margin-left:20px;">Sign Up</div></a></h5>
        </div></form>
        </div>
        
        
        <div class="slider-wrapper theme-default">
                <div class="slide" style="visibility:hidden;"">

            <ul id="slider" class="nivoSlider bxslider">
               <li> 
							 <div class="login-faces">
									<div class="lf-left">
										
										<a href="#">
										<div class="lf-box lf1">
											<img src="img/faces/lf1.jpg">
											<span>Bradd, Brisbane</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf2">
											<img src="img/faces/lf2.jpg">
											<span>Diana, Sydney</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf3">
											<img src="img/faces/lf3.jpg"><span>John, Sydney</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf4">
											<img src="img/faces/lf4.jpg"><span>Chrish, Sydney</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf5">
											<img src="img/faces/lf5.jpg"><span>John, Melbourne</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf6">
											<img src="img/faces/lf6.jpg"><span>Margaret, Brisbane</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf7">
											<img src="img/faces/lf7.jpg"><span>Bradd, Sydney</span>
										</div></a>
										
										<a href="#">
										<div class="lf-box lf8">
											<img src="img/faces/face1.jpg"><span>Sara, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf9">
											<img src="img/faces/lf9.jpg"><span>Naomi, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf10">
											<img src="img/faces/lf10.jpg"><span>Chrish, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf11">
											<img src="img/faces/lf11.jpg"><span>Chao, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf12">
											<img src="img/faces/face2.jpg"><span>Diana, Melbourne</span>
										</div>
										
										<a href="#"><div class="lf-box lf13">
											<img src="img/faces/lf13.jpg"><span>Bradd, Brisbane</span>
										</div></a>

										
									</div>
										
										<div class="lf-right">
										
										<a href="#"><div class="lf-box lf14">
											<img src="img/faces/lf14.jpg"><span>Chrish, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf15">
											<img src="img/faces/lf15.jpg"><span>John, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf16">
											<img src="img/faces/lf16.jpg"><span>Sara, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf17">
											<img src="img/faces/lf17.jpg"><span>Nicole, Sydney</span>
										</div>
										
										<a href="#"><div class="lf-box lf18">
											<img src="img/faces/lf18.jpg"><span>John, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf19">
											<img src="img/faces/lf19.jpg"><span>Bradd, Brisbane</span>
										</div></a>
										
	
										</div>
									
								
							 </div>
							 
							 
							 <div class="nivo-caption" style="display: block;">Meet people &amp; make new friends in Australia<h3>Chat with fun new people, share photos and interests!</h3></div>
							 
							 </li>
							 
							<li>
							 <div class="login-faces">
									<div class="lf-left">
										
										<a href="#"><div class="lf-box lf1">
											<img src="img/faces/lisa_19.jpg"><span>Lisa, Brisbane</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf2">
											<img src="img/faces/chrish_19_2.jpg"><span>John, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf3">
											<img src="img/faces/john_19.jpg"><span>Bradd, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf4">
											<img src="img/faces/lf14.jpg"><span>Chrish, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf5">
											<img src="img/faces/chrish_19.jpg"><span>Bradd, Brisbane</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf6">
											<img src="img/faces/lf16.jpg"><span>Sara, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf7">
											<img src="img/faces/jared.jpg"><span>Jared, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf8">
											<img src="img/faces/diana_19.jpg"><span>Chrish, Brisbane</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf9">
											<img src="img/faces/sara_19.jpg"><span>Sara, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf10">
											<img src="img/faces/john_19_2.jpg"><span>Chrish, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf11">
											<img src="img/faces/lf17.jpg"><span>Nicole, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf12">
											<img src="img/faces/sara_19_2.jpg"><span>Sara, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf13">
											<img src="img/faces/lf19.jpg"><span>Chrish, Brisbane</span>
										</div></a>

										
									</div>
										
										<div class="lf-right">
										
										<a href="#"><div class="lf-box lf14">
											<img src="img/faces/lf2.jpg"><span>Diana, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf15">
											<img src="img/faces/lf10.jpg"><span>John, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf16">
											<img src="img/faces/lf1.jpg"><span>Chrish, Brisbane</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf17">
											<img src="img/faces/ola_19.jpg"><span>Diana, Sydney</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf18">
											<img src="img/faces/lf6.jpg"><span>Margaret, Melbourne</span>
										</div></a>
										
										<a href="#"><div class="lf-box lf19">
											<img src="img/faces/lisa_19_2.jpg"><span>Lisa, Sydney</span>
										</div></a>
										
	
										</div>
									
								
							 </div>
							 
							 
							 <div class="nivo-caption" style="display: block;">Lorem ipsum dolor<h3>Eget eleifend sollicitudin, ipsum nisl eleifend purus !</h3></div>
							
							
</li>
            </ul>
							
        </div>
        
</div></div>
        
        
        
        <div  class="slidershadow"></div>
        <div style="width:990px;margin-left: auto;margin-right: auto;">

    
        <div class="width330"><div class="tytul">Meet new people</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        <div class="width330"><div class="tytul">Student, EDU & Homestay</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        <div class="width330"><div class="tytul">Help and win cool prizes!</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        
        <div class="horizonline"></div>
        <div class="whyjoin">WHY JOIN iSTUDENT ?</div>
        <div class="mainvideo"></div>
	</div>
    <div  class="slidershadow marginbot18"></div>
<?php include_once "html_includes/footer.php" ?>
</div>
<script  type="text/javascript">
 var frmvalidator = new Validator("login");
 frmvalidator.addValidation("email","req", "Please enter your Email Address");
frmvalidator.addValidation("password","req", "Please enter your Password");
 frmvalidator.addValidation("email","email", "Please enter a valid email");
 frmvalidator.EnableMsgsTogether();
</script>
</body>
</html>