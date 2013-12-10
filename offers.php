<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
if(isset($_SESSION['uid'])){$uid = $_SESSION['uid'];}
else{$uid = "";}
$studentid = clean_data($_GET['user_id']);
if($studentid == $uid){header("Location: /student/home");exit;}
$Wall = new Wall();
$user = new User();
if($user->uidcheck($studentid) == false){header("Location: /index");exit;}
hitcounter($studentid, "profile-photos");

$profile = $user->profilepicture($studentid);
$userdata = $user->userdata($studentid);
$age = calcutateAge($userdata['dob']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $userdata['firstname']. " ". $userdata['lastname']; ?> | Photos | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>


<script> var followinguser = 'false'; </script>
<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
		<div id="left">
			<div class="cool-border">
				<img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=144&h=151&q=100&s=1" class="to-change"/>
			</div>
			<div class="orange-button big-button">
            <?php
			$friendstatus = $Wall->FriendStatus($studentid, $uid);
			if($friendstatus == "already"){echo "<a href='#' title='Friends' status='already' id='addfriend'>Friends</a>";}
			elseif($friendstatus == "request"){echo "<a href='#' title='Request Sent' status='request' id='addfriend'>Request Sent</a>";}
						elseif($friendstatus == "requested"){echo "<a href='#' title='Wants to be Friends' status='request' id='addfriend'>Requested</a>";}

			else{echo "<a href='#' title='Add Friend' status='add' id='addfriend'>Add Friend</a>";}
			?>
            
            
            </div>
            
            
			<div class="lgray-button big-button">
            <?php
			$followerstatus = $Wall->FollowerStatus($studentid, $uid);
			if($followerstatus == "true"){echo "<a href='#' title='Following' status='true' id='followme'>Following</a>
			<script> var followinguser = 'true'; </script>
			";}
			else{echo "<a href='#' title='Follow Me' status='add' id='followme'>Follow Me</a>";}
			?>
            
            </div>
			<div id="qlink-container">
				<span class="gray">QUICK LINKS</span>
				<ul>
					<li ><a href="/profile/<?php echo $studentid; ?>" id="wall">Wall<span></span></a></li>
					<li><a href="/about/<?php echo $studentid;?>" id="about">About Me</a></li>
					<li ><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
					<li class="active"><a href="/offers/<?php echo $studentid; ?>" id="my-offers">My Offers</a></li>
					<li><a href="/friends/<?php echo $studentid; ?>" id="my-friends">My Friends (<?php echo $Wall->FriendCount($studentid);?>)</a></li>
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
			<?php include_once "config/block_ads.php"; ?>
			<div class="advert-block border">
				<a href="#" class="blue thin">See your ad here »</a>
			</div><!--advert block end-->
		</div> <!-- left side-->
		<div id="content" class="content">
			<div class="item-info"><h1><?php echo $userdata['firstname'] ." ". $userdata['lastname']; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($userdata['state'])){echo $userdata['state'].",";}?> Australia</div><br />
</div>
<div style="clear:both"></div>
<h1 class="my black">My Offers</h1>
			
			<div id="main-post">

					
					              <div style="clear:both"></div>           

                       
              <div style="margin-top:30px" id="content-post1"> 
					<?php
					$offers = $Wall->OfferGet($studentid);
					while($row=mysqli_fetch_array($offers)){
						$id = $row['offerid'];
	$offer = $row['offer'];
	$offertext = $row['offertext'];
	echo <<<END
	<div id="offer_$id" class="post main border" style="margin-bottom:30px;">
	<span class="yes-2"></span><h2>$offer</h2><div style="clear:both"></div><br />$offertext</div>	
END;
					}
					
					?>
			
			</div></div>
            
            </div>
				
			
		
        <div id="right">
			
			<div id="profile-nav">
				<a href="/search-student" id="nav-search" class="navtip"><b><</b><span>Search Profiles</span></a>
			</div><!-- end profile navigation-->
			
			<div id="massage-box" class="border">
            <?php if(isset($_SESSION['uid'])): ?>
				<span>Send me a message!</span>
				<div class="green-button big-button"><a href="/student/messages/<?php echo $studentid; ?>" title="Message Me" id="message">Message Me</a></div>
                <?php endif; ?>
			</div>
			
			<div id="right-baner">
				<img src="/img/advert_top.png" />
				<div></div>
			</div>
				
		</div><!-- right side-->
  </article>
           
<?php include_once "html_includes/footer.php" ?>
</div>
       <?php if($_SESSION['uid'] != ""):?>
            <script>
			$(document).ready(function() 
{
	$('#followme').die('click').live("click",function() 
{	
	var status = $(this).attr("status");
if(status == "add"){
var URL='/addfollower_ajax.php';
var dataString = 'studentid=' + <?php echo $studentid; ?>;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
if(html == "true"){
$('#followme').html('Following').attr('status', 'true');
followinguser = 'true';
}
}
 }
 });
}
return false;
});
$('#addfriend').die('click').live("click",function() 
{	
	var status = $(this).attr("status");
if(status == "add"){
var URL='/addfriend_ajax.php';
var dataString = 'studentid=' + <?php echo $studentid; ?>;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
if(html == "success"){
$('#addfriend').html('Request Sent').attr('status', 'request');}
else{$('#addfriend').html('Friends').attr('status', 'already');}
}
 }
 });
}
return false;
});
});
</script><?php endif;?>
</body>
</html>