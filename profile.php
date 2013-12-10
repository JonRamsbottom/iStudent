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
hitcounter($studentid, "profile");

$profile = $user->profilepicture($studentid);
$userdata = $user->userdata($studentid);
$age = calcutateAge($userdata['dob']);

if($_GET['sort'] == "all"){$sort = "all";}
elseif($_GET['sort'] == "my"){$sort = "my";}
else{$sort="all";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $userdata['firstname']. " ". $userdata['lastname']; ?> | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
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

<style>
.preview
{
border:solid 1px #333;
max-width:150px;
max-height:125px;
margin-bottom:10px;
margin-left:10px;
}
.img_container
{
	
	text-align: center;
	background-color: #333;
	line-height:0px;
	
	clear: both;
	border:1px solid #e1e1e1;
	max-height:330px;
	overflow:hidden;
}

.imgpreview
{
max-width:100%;
max-height:100%;
border:1px #solid #e1e1e1;
}

</style>
<script> var followinguser = 'false'; </script>
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
					<li class="active"><a href="#" id="wall">Wall<span></span></a></li>
					<li><a href="/about/<?php echo $studentid;?>" id="about">About Me</a></li>
					<li><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
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
		<div id="content" class="content">
			<div class="item-info"><h1><?php echo $userdata['firstname'] ." ". $userdata['lastname']; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($userdata['state'])){echo $userdata['state'].",";}?> Australia</div><br />

			<p><?php echo $status; ?></p></div>
		
			<div id="wall-post">
				<form action="" type="" class="post-form">
					<input name="subject" id="subject" class="input-border gray" type="text" placeholder="Subject"/>
					<textarea name="updatetext" id="updatetext" class="input-border gray" placeholder="Ask something"></textarea>
					<div id="tab-arrow-4"><span></span></div>


                







					<ul>
						<li id="wall-textb"><a href="#"><span class="gray">TEXT</span></a></li>
						<li id="wall-photosb"><a id="photoupload" href="#"><span class="gray">PHOTOS</span></a></li>
						
					</ul>
					
					<button id="post-action" class="orange-button small-button">Post</button>
				</form>
			<br /><br />
<br />


                                <div id="imageupload" style="height:auto; width:500px; margin-left: 20px; display:block;width:500px; overflow:auto; display:none">
<form id="imageform" method="post" enctype="multipart/form-data" action='/message_image_ajax.php'> 
<div id='preview'>
</div>
<div id='imageloadstatus' style="display:none;">
<img src='http://istudent.blakebytes.com.au/testistudent/wall_icons/ajaxloader.gif'/> Uploading please wait ....
</div>
<div id='imageloadbutton'>
<span id='addphoto'><strong>Add Photo:</strong></span> <input type="file" name="photoimg" id="photoimg" />
</div>
<input type='hidden' id='uploadvalues' />
</form>
            </div>
            <?php if($uid != ""):?>
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
	
	
	
	
			$('#photoupload').die('click').live("click",function() 
{
$('#imageupload').slideToggle('fast');
return false;
});

$('#photoimg').die('click').live('change', function()			
{ 
var values=$("#uploadvalues").val();
$("#previeww").html('<img src="wall_icons/loader.gif"/>');
$("#imageform").ajaxForm({target: '#preview', 
     beforeSubmit:function(){ 
	 $("#imageloadstatus").show();
	 $("#imageloadbutton").hide();
	 }, 
	success:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	}, 
	error:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	} }).submit();

var X=$('.preview').attr('id');

var Z= X+','+values;
if(Z!='undefined,')
{
$("#uploadvalues").val(Z);
}

});


$("#post-action").click(function() 
{
var updateval = $("#updatetext").val();
var subjectval = $("#subject").val();
var uploadvalues=$("#uploadvalues").val();

var X=$('.preview').attr('id');
if(X)
{
var Z= X+','+uploadvalues;
}
else
{
var Z=0;
}
var dataString = 'update='+ updateval+'&subject='+subjectval+'&uploads='+Z+'&student=<?php echo $studentid; ?>';
if(followinguser == 'false'){
	alert("You must be following this user to ask something");}
else if($.trim(updateval).length==0)
{
alert("Please Enter Text");
}
else if($.trim(subjectval).length==0)
{
alert("Please Enter a Subject");
}
else
{
$.ajax({
type: "POST",
url: "/message_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#content-post1").prepend(html);
$("#updatetext").val('').focus();	
$("#subject").val('').focus();	
$('#preview').html('');
$('#uploadvalues').val('');
$('#photoimg').val('');
FB.XFBML.parse();

}
 });
 $("#preview").html('');
$('#imageupload').slideUp('fast');
}
return false;
	});


$('.morelink').die('click').live("click",function() 
{

var ID = $(this).attr("id");
var P_ID = $(this).attr("rel");
var URL='/wall_post_more.php';
var dataString = "lastid="+ ID+"&profile_id="+P_ID+"&sort=<?php echo $sort; ?>";
if(ID)
{
$.ajax({
type: "POST",
url: URL,
data: dataString, 
cache: false,
beforeSend: function(){ $("#more"+ID).html('<img src="wall_icons/ajaxloader.gif" />'); },
success: function(html){
$("#content-post1").append(html);
$("#more"+ID).remove();
FB.XFBML.parse();

}
});
}
return false;
});

//Like and Unlike
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


$('.commentopen').die('click').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('fast');
$("#commenttextarea"+ID).focus();
return false;
});

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

				<div id="post-hr"></div>
					
					<form id="sort-form">
						<label for="sortpost">SORT</label>
						<div id="post-sort">
						<select id="sortpost" name="sortpost">
						<option value=""></option>
						<option value="profile?user_id=<?php echo $studentid; ?>&sort=all">All Post</option>
						<option value="profile?user_id=<?php echo $studentid; ?>&sort=my">My Posts</option>
						</select>
						</div>
					</form>
                    <script>
$("#sortpost").change(function() {
  window.location = $(this).find("option:selected").val();
});
</script>
                    <div id="content-post1" >            
<?php include_once "wall_load.php"; ?>
					
			
			</div></div>
            <?php include_once "more_load.php"; ?>
            </div>
			
			
			
			
		</div><!-- content-->
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

</body>
</html>