<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
if(isset($_SESSION['uid'])){$uid = $_SESSION['uid'];}
else{$uid = "";}
$studentid = clean_data($_GET['user_id']);
$postid = clean_data($_GET['id']);
$Wall = new Wall();
$user = new User();
if($user->uidcheck($studentid) == false){header("Location: /index");exit;}
$q = mysqli_query($dbc, "SELECT * FROM messages WHERE msg_id='$postid' AND uid_fk='$studentid'");
if(mysqli_num_rows($q) == 0){header("Location: /index");exit;}
if($uid == $studentid){$uid = $studentid;}
else{hitcounter($studentid, "profile");}

$profile = $user->profilepicture($studentid);
$userdata = $user->userdata($studentid);
$age = calcutateAge($userdata['dob']);
$data = mysqli_fetch_array($q);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $userdata['firstname']. " ". $userdata['lastname']; ?> | <?php echo $data['subject']; ?> | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="<?php echo implode(' ', array_slice(explode(' ', $data['message']), 0, 60))?>" />
 <meta property="og:description" content="<?php echo implode(' ', array_slice(explode(' ', $data['message']), 0, 60)) ?>"/>
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery-ui.min.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.wallform.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.livequery.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.timeago.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.tipsy.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/lean-slider.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/9lessons.alert.js"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=472036489547361";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
<?php
if($uid != $studentid):
?>
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
					<li><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
					<li><a href="/offers/<?php echo $studentid; ?>" id="my-offers">My Offers</a></li>
					<li><a href="/friends/<?php echo $studentid; ?>" id="my-friends">My Friends (<?php echo $Wall->FriendCount($studentid);?>)</a></li>
				</ul>
			</div><!-- qlinks container-->
			<?php else: ?>
            <div id="left">
			<div class="cool-border">
				<img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=144&h=151&q=100&s=1" class="to-change"/>
				<a href="/student/account" class="gray2">Change Profile Picture</a>
			</div>
	
			<div id="qlink-container">
				<span class="gray">QUICK LINKS</span>
				<ul>
					<li><a href="/student/home" id="wall">My Wall</a></li>
					<li><a href="/student/dashboard" id="my-dashboard">My Dashboard</a></li>
					<li><a href="/student/about-me" id="about-me">About Me</a></li>
					<li><a href="/student/photos" id="my-photos">My Photos</a></li>
					<li><a href="/student/my-offers" id="my-offers">My Offers</a></li>
					<li><a href="/student/my-friends" id="my-friends">My Friends (<?php echo $Wall->FriendCount($uid); ?>)</a></li>
				</ul>
			</div><!-- qlinks container-->
<?php endif; ?>
			
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

			<p><?php echo $status; ?></p></div>
		
			<div id="wall-post">
				
            <?php if($uid != ""):?>
            <script>
			$(document).ready(function() 
{
$('.comment_save').die('click').live("click",function() 
{

var ID = $(this).attr("id");
var msg = $(this).attr("id");
var URL= '/comment_ajax.php';
var comment= $("#commenttextarea"+ID).val();
var dataString = 'comment='+ comment + '&msg_id=' + msg;

if($.trim(comment).length==0)
{
alert("Please Enter a Comment");
}
else
{
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
	if(html != ""){
$("#commentcontain"+ID).append(html);
var num = parseInt($('#commentcount'+ID).html());
$('#commentcount'+ID).html(num+1);
$("#commenttextarea"+ID).val('').focus();}
else{alert("Error: Comment already posted.");
$("#commenttextarea"+ID).val('').focus();
}
 }
 });
}
return false;
});
$('.saythanks').die('click').live("click",function() 
{	var thanked = $(this).attr("thanked");
	var msgid = $(this).attr("msg_id");
	if(thanked != 'true'){
var URL='/saythanks_ajax.php';
var dataString = 'msg_id=' + msgid;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
$('#saythanks'+msgid).html('You Said Thanks (').attr('thanked', 'true');

$("#saythankscount"+msgid).html(html);
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
});
</script><?php endif;?>
          <script>
		  $("span.lgray").livequery(function () { $(this).timeago(); });		  
		  $('.commentopen').die('click').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('fast');
$("#commenttextarea"+ID).focus();
return false;
});
</script>  
            
			<div id="main-post">


					
					
                    
                    <div id="content-post1" >            
<?php
$full = "full";
include_once("html_post.php");
?>
					
			
			</div></div>
            
            </div>
			
			
			
			
		</div><!-- content-->
        <?php
		if($uid == $studentid){include_once "student/right_side_block.php";}
		else{?>
        <div id="right">
			
			<div id="profile-nav">
				<a href="/search-student" id="nav-search" class="navtip"><b><</b><span>Search Profiles</span></a>
			</div><!-- end profile navigation-->
			
			<div id="massage-box" class="border">
				<span>Send me a message!</span>
				<div class="green-button big-button"><a href="#" title="Message Me" id="message">Message Me</a></div>
			</div>
			
			<div id="right-baner">
				<img src="/img/advert_top.png" />
				<div></div>
			</div>
				
		</div><!-- right side--><?php } ?>
	</article>

<?php include_once "html_includes/footer.php" ?>
</div>

</body>
</html>