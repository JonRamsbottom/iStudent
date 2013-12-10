<?php
session_start();
include("../config/dbconfig.php");
include("../config/common.php");
include("../config/iStudentUSER.php");
include("../config/Wall.php");

include("../config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
include("../config/public.php");

$profile = $user->profilepicture($uid);
$studentid = $uid;
$age = calcutateAge($dob);

if(isset($_POST['account-submit'])){
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>Account Settings | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery-ui.min.js"></script>

<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.wallform.js"></script>




<style>
.middle-content{
width: 610px;
margin-left:25px;}
.form1 label ,
.form12 label ,
.form22 label {
display:block;
width:100%;
margin-bottom:4px;
}

.form1 ,
.form12 ,
.form22 {
margin-bottom:16px;
}

.form1 {
	width:100%;
	display:block;
	float:left;

}

.form12 select, #left2 .form22 select{
	width:104px;
		padding:5px 5px 4px;
}
.form1 select, #left2 .form1 input[type='date']{
	padding:5px 5px 4px;
	width:212px;
}
.form1 input[type='date'],  .form1 input[type='text'], .form1 input[type='password']{
	padding:5px 5px 4px;
	width:200px;
}
.form1 textarea{width:200px; 	padding:5px 5px 4px;}

</style>
</head>

<body>
<div id="containbody">
<?php include_once "../html_includes/header.php" ?>
<article>
		<div id="left">
			<div class="cool-border">
				<img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=144&h=151&q=100&s=1" class="to-change"/>
				<a href="/student/account" class="gray2">Change Profile Picture</a>
			</div>
	
			<div id="qlink-container">
				<span class="gray">QUICK LINKS</span>
				<ul>
					<li><a href="home" id="wall">My Wall</a></li>
					<li><a href="dashboard" id="my-dashboard">My Dashboard</a></li>
					<li><a href="about-me" id="about-me">About Me</a></li>
					<li><a href="photos" id="my-photos">My Photos</a></li>
					<li><a href="my-offers" id="my-offers">My Offers</a></li>
					<li><a href="my-friends" id="my-friends">My Friends (<?php echo $Wall->FriendCount($uid); ?>)</a></li>
				</ul>
			</div><!-- qlinks container-->
			
			<div id="profile-complet" class="border">
				<span class="gray2">Profile completion</span>
				<b>80%</b><a href="#" class="blue">Add/Edit</a>
				<div class="stat-div"><span style="width: 80%;"></span></div>
			</div><!-- profile completion end-->
			
			<div class="advert-block border">
				<span class="gray">ADS YOU MAY BE INTERESTED IN</span>
			</div><!--advert block end-->
			<?php include_once "../config/block_ads.php"; ?>
			<div class="advert-block border">
				<a href="#" class="blue thin">See your ad here »</a>
			</div><!--advert block end-->
		</div> <!-- left side-->
		<div id="content" class="content">
			<div class="item-info"><h1><?php echo $fname ." ". $lname; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($data['state'])){echo $data['state'].",";}?> Australia</div>
			</div>
<div style="clear:both;"></div>
		<div class="middle-content">
       <h1>Account Settings</h1>
       <br /><br /><br />
<form action="" method="post" enctype="multipart/form-data" name="account">

<div style="float:left; width:48%">
<div class="form1">
<label for="fname">First Name</label>
  <input name="fname" type="text" id="fname" maxlength="60" value="<?php echo $fname; ?>" />
  </div>
   <div class="form1">
<label for="lname">Last Name</label>
  <input name="lname" type="text" id="fname" maxlength="60" value="<?php echo $lname; ?>" />
  </div>
  <div class="form1">
<label for="email">Email Address</label>
  <input name="email" type="text" id="email" value="<?php echo $data['email']; ?>" />
  </div>

</div>
<div style="float:left; width:48%">
<div class="form1">
<label for="pass1">New Password</label>
  <input name="pass1" type="password" id="pass1"  />
  </div>
  <div class="form1">
<label for="pass2">Confirm New Password</label>
  <input name="pass2" type="password" id="pass2"  />
  </div>
  
</div></form>
	  <div class="form1" style="margin-top:20px">
      <div style="float:left; width:300px">
  <div id='imageloadstatus' style="display:none;">
<img src='http://istudent.blakebytes.com.au/testistudent/wall_icons/ajaxloader.gif'/> Uploading please wait ....
</div>
<div id='imageloadbutton'>
<form id="imageform" enctype="multipart/form-data" method="post" action="/upload_profile_ajax.php">
    <label for="profile"><strong>Upload Profile Picture</strong></label>
    <input type="file" name="profile" id="profile" />
    </form>
</div>
  <div style="margin-top:10px;" id="preview-img"><?php
  	 echo "<img style='border:solid 1px #333;' src='/config/timthumb.php?src=$profile&w=144&h=170&q=90&s=1'/>";

  
  ?>
  </div></div>
  <div style="float:left;width:300px;">	
  <br />
  <?php
  if(!empty($data['facebook_id'])): ?>
<button style="margin-top:10px;width:200px" id="facebook-upload" class="orange-button" >Get Profile Picture from Facebook</button>
<?php endif; ?>
</div>
  </div>
            
  </div>
			
			
</div><!-- content-->

		<?php include_once "right_side_block.php"; ?>
	</article>
    <?php include_once "../html_includes/footer.php" ?></div>
<script>
		
$(document).ready(function() 
{

$('#profile').die('click').live('change', function()			
{ 
$("#imageform").ajaxForm({ 
     beforeSubmit:function(){ 
	 $('#preview-img').html('');
	 $("#imageloadstatus").show();
	 $("#imageloadbutton").hide();
	 }, 
	target: "#preview-img",

	success:function(msg){ 
        $('#preview-img').hide().html(msg).fadeIn('slow'); 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	 	 	 $('#profile').val('');
	 $("#preview-img").html(data);

	}, 
	error:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	} }).submit();



});


$("#facebook-upload").click(function() 
{
	 $("#imageloadstatus").show();
	 $("#imageloadbutton").hide();
$.ajax({
type: "POST",
url: "/upload_profile_fb.php",
cache: false,
success: function(html)
{

$("#preview-img").html(html).fadeIn('slow');
$("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
}
 });
return false;
	});
	
});

</script>
</body>
</html>