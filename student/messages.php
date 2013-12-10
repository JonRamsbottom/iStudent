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
$conversation_uid='';
if($_GET['message_username'])
{
	$conversation_usr = clean_data($_GET['message_username']);
	$conversation = $user->uidcheck($conversation_usr);
	if($conversation)
	{
	$conversation_uid=$conversation_usr;
    if($conversation_uid!=$uid)
    {
	$top_c_id= $Wall->Conversation_Insert($uid,$conversation_uid);
    }
	else
	{
		header("Location: /student/messages");
	
    }
	
   }
	else
	{
			header("Location: /student/messages");
    }

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
<title>My Messages | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

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
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.slimscroll.min.js"></script>

<style>
.conList {
border-bottom: solid 1px #dedede;
background-color:#ffffff;
padding: 10px;
min-height: 50px;
cursor: pointer;
}
.conList:hover{background-color:#dedede}
.cname{font-weight:bold;margin-left:10px;font-size:12px}
.reply{margin-left:10px;font-size:11px;color:#666}
.cimg {
width: 50px; height:50px;
float: left;
}

#reply_content, #replylist_content
{
min-height:440px !important;
}
.reply_stbody
{
padding:5px 5px 5px 0px;
overflow:auto;
border-bottom: 1px solid #f2f2f2;
}
.reply_stimg
{
float:left;
min-height:50px;
width:50px;
}
.reply_sttext
{
line-height:20px;
margin-left:70px;
min-height:50px;
word-wrap:break-word;
overflow:hidden;
display:block;
font-size:13px;
background-color:#ffffff;
border-radius:4px;
-moz-border-radius:4px;
-webkit-border-radius:4px;
}
.reply_sttext b
{
display:block;
}
.reply_sttext b a
{
	color:#000000;
}
#main_right
{
	width:530px;float:left; border-left:solid 1px #e1e1e1; padding:10px;margin-top:10px;min-height:550px;
}
#main_left
{
	width:240px;float:left;margin-top:10px;
}
.con_name{display:block;height:70px;text-decoration:none !important}
.con_send{vertical-align:middle; margin-right:5px}
.con_time{margin-left:10px;color:#999;font-size:11px;margin:0px 0px 0px 10px !important;}
.timeago
{
	height:14px;
	padding-right:18px;
	margin-right:20px;
	text-transform:uppercase;
	font-size:12px;
	background:url(/images/timelite.png) right no-repeat;
}
.big_face
{
width:60px;height:60px;margin-bottom:5px;
border-radius:4px;
-moz-border-radius:4px;
-webkit-border-radius:4px;
border: solid 1px #d6d7da;
}
.timeago
{
	color:#999999;
	text-decoration:none;	
}
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
					<li><a href="/student/home" id="wall">My Wall</a></li>
					<li><a href="/student/dashboard" id="my-dashboard">My Dashboard</a></li>
					<li><a href="/student/about-me" id="about-me">About Me</a></li>
					<li><a href="/student/photos" id="my-photos">My Photos</a></li>
					<li><a href="/student/my-offers" id="my-offers">My Offers</a></li>
					<li> <a href="/student/my-friends" id="my-friends">My Friends (<?php echo $Wall->FriendCount($uid); ?>)</a></li>
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
		<div id="content-long" class="content">
			<div class="item-info"><h1><?php echo $fname ." ". $lname; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($data['state'])){echo $data['state'].",";}?> Australia</div>
			</div>
<div style="clear:both;"></div>
			<div id='main_left' style="border-top:solid 1px #dedede;">
                       <div class="some-content-related-div">
		       <div id="replylist_content" class="conversation_grid">
               
			   <?php 
			if($conversation_uid)
			{
			include('conversation_load_single.php');
			}
			include('conversation_load.php'); ?>
				
				</div>
				</div>
	
			</div>

<div id="main_right" style='background-color:#ffffff;border-bottom:solid 1px #dedede;border-top:solid 1px #dedede;'>
<div class="some-content-related-div">
<div id="reply_content" class='conversationReply_grid'>
<?php 
include('html_ConversationReply.php');
        if(empty($Conversation_Updates)){ 
		if($top_c_id)
		{
			$data = $user->userdata($conversation_usr);
			$name = $data['firstname']. " ".$data['lastname'];
		echo "<b>Start a conversation with ".$name."</b>";	
		}
		else
		{
		echo "<b>No conversation selected.</b>";
		}
		 }
?>	
</div>
</div>

<?php if($top_c_id) { ?>

<div id="updateboxarea" >
<h5>Write a reply...</h5>
<input type="hidden" id="cid" value="<?php echo $top_c_id;?>">
<textarea class="main-body" name="update" id="update" maxlength="200" style="width:524px !important;"></textarea>
<button style="margin-top:5px;margin-right:5px;" class="reply_button orange-button width100">REPLY</button>
Enter to Send:
<input name="enter-send" type="checkbox" id="enter-send" value="Y" checked="checked" />

</div>
<?php } ?>
</div>
			
			
		</div><!-- content-->

  </article>
<?php include_once "../html_includes/footer.php" ?></div>

<script>
	function htmlEscape(str) {
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}
	

function list_more_reply(dataString)
{
	$.ajax({
	type: "POST",
	url: "/student/html_conversationreply_ajax.php",
	data: dataString,
	cache: false,
	success: function(html){
	if($.trim(html).length>0)
	{
	 $("#reply_content").prepend(html);
	}
	else
	{
	$("#reply_content").removeClass('conversationReply_grid').addClass('conversation_grid_blockk');
	}
	
	 }
	 });
}
$(document).ready(function()
{
<?php $mes=""; if(isset($_GET['message_username']) && !empty($Conversation_Updates)): $mes = "true";?>

	
function getmessages(){
	var C_ID=$('#cid').val();
		var ID = $(".reply_stbody:last").attr("id");
		var sid = ID.split("stbody"); 
		var New_ID = sid[1];
		var dataString = 'last_time='+ New_ID +'&c_id='+C_ID;
		
		$.ajax({
type: "POST",
url: "/student/conversationupdate_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
	if($.trim(html).length>0)
	{
$("#reply_content").append(html);
$("#reply_content").animate({"scrollTop": $('#reply_content')[0].scrollHeight}, "slow");
 setTimeout(getmessages, 4000);

	}
}
 });
}
getmessages();
<?php endif; ?>
	
	$("#reply_content").animate({"scrollTop": $('#reply_content')[0].scrollHeight}, "slow");
	var playlist_content_height = 570;

	
	
	
	var playlist_contentReply_height = 470;

	$('.conversationReply_grid').scroll(function(eve){	
	var a=0;
	var s=$(document).height() - playlist_contentReply_height;
    
	if ($('.conversationReply_grid').scrollTop() == 0){
		var b=0;
	    var C_ID=$('#cid').val();
		var ID=$(".reply_stbody:first").attr("id");
		var sid=ID.split("stbody"); 
		var New_ID=sid[1];
		var dataString = 'last_time='+ New_ID +'&c_id='+C_ID;
		
	    if(b == 0){
		list_more_reply(dataString,C_ID);
		b = 1;	
    	}

		
	}

	});
	
	$('#replylist_content').slimScroll({
	        height: playlist_content_height+'px'
			
	});

	$('#reply_content').slimScroll({
	        height: '440px',
			start: 'bottom',

	});
	
	$("span.timeago").livequery(function () { $(this).timeago(); });
function sendmessage(){
		var A=$('#update').val();
		var B=$('#cid').val();
	     
		var dataString = 'reply='+ A +'&cid='+B;
		    if($.trim(A).length>0)
		    {
				
			$.ajax({
			type: "POST",
			url: "/student/conversation_ajax.php",
			data: dataString,
			cache: false,
			success: function(html)
			{	
			if(html)
			{
			
			if(A.length > 20) 
			{
			A = A.substring(0,17);
			A+='...';
		    }
			
			$('#reply'+B).html("<img src='/images/send.png'  class='con_send'/> "+htmlEscape(A));
			$('#reply_content').append(html);
			$("#reply_content").animate({"scrollTop": $('#reply_content')[0].scrollHeight}, "slow");
			$('#update').val('');
			$('#update').focus();
							
			}
			}
			});
		}}
	$(".reply_button").live("click",function(){
	sendmessage();
			return false;

	
	});
	
$('.main-body').keypress(function(event) {
    if (event.keyCode == 13 && $("#enter-send").is(':checked')) {
       sendmessage();
    }
});
	
	
	
	
	
	setInterval(getside,3000);
getside();
function getside(){
		var dataString = 'cid=<?php echo $conversation_uid; ?>&top=<?php echo $top_c_id; ?>';
		
		$.ajax({
type: "POST",
url: "/student/messageside_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
	if($.trim(html).length>0)
	{
	$("#replylist_content").html(html);
			$('span.timeago').timeago('refresh');

	}
	
}
 });
}
});
</script>	
</body>
</html>