<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");

$user = new User();

if(isset($_POST['signup-submit'])){
	if($_SESSION['signup-checksum'] == $_POST['signup-checksum']){
		if(inputcheck($_POST['fname']) && inputcheck($_POST['lname']) && inputcheck($_POST['email']) && inputcheck($_POST['password']) && inputcheck($_POST['gender'])){
				if($user->checkemail($_POST['email']) == true){$error="That email address is currently in use. Please use another one.";}
			else{	
			$usernum = $user->userregister($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['gender']);
			if($usernum != false){
				$user->sessionadd($usernum, 1);
				header("Location: home.php");
			    exit;
				}}
			
						
		}
		else{$error = "Please ensure all fields are completed.";}
		
	}
	else{$error="An error occured. Please try again.";}
	
	header("Location: index.php");
	$_SESSION['signup-error'] = $error;
	exit;
	}
$_SESSION['signup-checksum'] = sha1(microtime());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link href="/css/jquery.bxslider.css" rel="stylesheet" />
<?php include_once "html_includes/js.php" ?>
<script type='text/javascript'>
if (top.location!= self.location)
{
top.location = self.location
}
</script>
<script src="/js/gen_validatorv4.js"></script>
<script src="/js/jquery.bxslider.min.js"></script>


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
		
        <div class="kontener100">
                <form id="signup" name="signup" action="" method="post">

        <div id="signup">
        	<h1>Sign up</h1>
            <a href="/login-facebook"><button type="button" class="facebtn"><i class="faceico"></i><b>Connect with Facebook</b></button></a>
            <div class="or2"></div>
            <div class="cont372"><input name="fname" type="text" placeholder="First Name"><i class="nameico"></i></div>
            <div class="cont372"><input name="lname" type="text" placeholder="Last Name"><i class="nameico"></i></div>
            <div class="cont372"><input name="email" type="email" placeholder="Email Address"><i class="emailico"></i></div>
            <div class="cont372"><input name="password" type="password" placeholder="Password"><i class="passico"></i></div>
          <input type="hidden" name="signup-submit" value="TRUE" /><input type="hidden" name="signup-checksum" value="<?php echo $_SESSION['signup-checksum'];?>" />
              <label>
                <input type="radio" name="gender" value="M" id="gender_0" />
                Male</label>
              <label>
                <input type="radio" name="gender" value="F" id="gender_1" />
                Female</label>
              <br />
               <span class='error' style="font-size:12px; color:#F00">
        <?php session_start(); echo $_SESSION['signup-error'];  unset($_SESSION['signup-error']); ?>
        </span>
              <br />

<h5>By clicking Sign Up, you agree to our<div class="showmore" style="display:inline-block; margin:0px 7px;"> Terms and Policy</div></h5>
        <button class="logbtn"><b>Sign Up</b></button>
        <h5>Already an iStudent member? <a href="login"><div class="showmore" style="display:inline-block; margin-left:5px;">Log in?</div></a></h5>
        </div>          </form>

        </div>
        
        
        <div class="slider-wrapper theme-default">
        <div class="slide" style="visibility:hidden;"">
           <ul id="slider"   class="nivoSlider bxslider">
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
										</div></a>
										
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
										</div></a>
										
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
        
        
        
        <div class="slidershadow"></div>
    <div style="width:990px;margin-left: auto;margin-right: auto;">
    
        <div class="width330"><div class="tytul">Meet new people</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        <div class="width330"><div class="tytul">Student, EDU & Homestay</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        <div class="width330"><div class="tytul">Help and win cool prizes!</div><div class="tekst">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros sit amet sollicitudin.</div><div class="guzik">Learn More</div></div>
        
        <div class="horizonline"></div>
        <div class="whyjoin">WHY JOIN iSTUDENT ?</div>
        <div class="mainvideo"></div>
	</div>
    <div  class="slidershadow marginbot18"></div>
<?php include_once "html_includes/footer.php" ?></div>
<script  type="text/javascript">
 var frmvalidator = new Validator("signup");
 frmvalidator.addValidation("fname","req","Please enter your First Name");
frmvalidator.addValidation("lname","req", "Please enter your Last Name");
 frmvalidator.addValidation("email","req", "Please enter your Email Address");
frmvalidator.addValidation("password","req", "Please enter a Password");
 frmvalidator.addValidation("email","email", "Please enter a valid email");
 frmvalidator.addValidation("gender","selone", "Please select your Gender");
 frmvalidator.EnableMsgsTogether();
</script>

</body>
</html>