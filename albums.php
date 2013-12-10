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
$profile = $user->profilepicture($studentid);
$userdata = $user->userdata($studentid);
$age = calcutateAge($userdata['dob']);

$album = clean_data($_GET['album_id']);
if($Wall->AlbumGetData($album, $studentid) == 0){header("Location: /index");}
else{$data = $Wall->AlbumGetData($album, $studentid);
$albumname = $data['albumname'];
	}
	
if($Wall->PhotoGet($album) == ""){$count = 0;}
else{$count = mysqli_num_rows($Wall->PhotoGet($album));}
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
<link href="/css/lightbox.css" rel="stylesheet" />
<script src="/js/lightbox-2.6.min.js"></script>

<script type="text/javascript">
function mainimg(source, large){
	var myimage = document.getElementById('large-image');
	var myhref = document.getElementById('image-big');
	myimage.src= source;
	myhref.href = large;	
}
function makemain(source, large){
	mainimg(source, large);
}
</script>

<script> var followinguser = 'false'; </script>
<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
		<div id="left">
			<div class="cool-border">
				<img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=144&h=151&q=100" class="to-change"/>
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
					<li class="active"><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
					<li><a href="/offers/<?php echo $studentid; ?>" id="my-offers">My Offers</a></li>
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
		<div id="content-long" class="content">
			<div class="item-info"><h1><?php echo $userdata['firstname'] ." ". $userdata['lastname']; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($userdata['state'])){echo $userdata['state'].",";}?> Australia</div><br />
</div>
<div style="clear:both"></div>
<h1 class="my black">Photos - <?php echo $albumname; ?></h1>
			
			<div id="my-info" class="gradient">
				
				
				<p class="info2">
				Total Albums<br />
				<span id="album-count"><?php echo mysqli_num_rows($Wall->AlbumGet($studentid)); ?></span>
				
				</p>
				
				<div class="vborder"></div>
				
				<p class="info2">
				Photos in Album<br />
				<span><?php echo $count; ?></span>
                <b></b>
				</p>
				
				
				
				
			</div><!-- my info end-->
			
			<div id="photos">
				<?php
				if($count != 0){
					$q = mysqli_query($dbc, "SELECT filename FROM photos WHERE albumid='$album' ORDER BY photoid DESC LIMIT 1");
					$img = mysqli_fetch_array($q);
					$filenamemain = $img['filename'];
					$filename = "/config/timthumb.php?src=/uploads/user-imgs/$filenamemain&w=752&h=514&q=100&zc=2";
					$href = "/uploads/user-imgs/$filenamemain";
					}
				else{$filename="/images/default-photo.png";$href="/images/default-photo.png";}
				?>
			<a href="<?php echo $href; ?>" id="image-big" data-lightbox="imagebig" title=""><img src="<?php echo $filename; ?>" id="large-image" /></a>
								<div id="post-hr" style="width:750px; margin-bottom:15px; margin-top:5px;"></div><div style="clear:both"></div>

				<div id="thumbs">
                <?php
				$query = $Wall->PhotoGet($album);
				while($row=mysqli_fetch_array($query)){
					$filename = $row['filename'];
					$id = $row['photoid'];
					echo <<<END
									<img src="/config/timthumb.php?src=/uploads/user-imgs/$filename&w=88&h=81&q=100" id="$id" onClick="mainimg('/config/timthumb.php?src=/uploads/user-imgs/$filename&w=752&h=514&q=100&zc=2', '/uploads/user-imgs/$filename')" class="photo_thumb"/>

END;
				}
				
				
				
				?>
				
							
				</div>
				
			</div><!-- photos end-->
				
			</div><!-- content-->
		</div><!-- content-->
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