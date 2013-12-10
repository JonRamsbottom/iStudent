<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/edu-provider.php");

if(isset($_SESSION['uid'])){$uid = $_SESSION['uid'];}
else{$uid = "";}
$Wall = new Wall();
$user = new User();
$educlass = new EducationProvider();
$eid = clean_data($_GET['id']);
if($educlass->checkedu($eid) == 0){header("Location: /index");
}
else{$edudata = $educlass->getedu($eid);}

$address = "";
if(!empty($edudata['street'])){$address.=$edudata['street'].", ";}
if(!empty($edudata['city'])){$address.=$edudata['city'].", ";}
$address.=$edudata['state']." ".$edudate['postcode'];

if(empty($edudata['profile_picture'])){$profile = "/images/default-album.png";}
else{$profile = "/uploads/edu/".$edudata['profile_picture'];}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl" dir="ltr">
  <head>
    <title><?php echo $edudata['name']; ?> | Education Provider | iStudent</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link href="/css/jquery-ui2.css" rel="stylesheet" />
<link href="/css/lightbox.css" rel="stylesheet" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>

<script src="/js/lightbox-2.6.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script type="text/javascript">
function mainimg(source, large){
	var myimage = document.getElementById('edu-image');
	var myhref = document.getElementById('image-big');
	myimage.src= source;
	myhref.href = large;	
}


$(function() {
$( "#tabs" ).tabs();
});

</script>

</head>
<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
	
	<article>
		<div id="left">
			<div class="cool-border">
				<img src="<?php echo $profile; ?>" />
			</div>
			<div class="orange-button big-button"><a href="#" title="Enroll Now" id="enroll">Enroll Now</a></div>
            <?php if($edudata['scholarship'] == "Y"): ?>
			<div class="lgray-button big-button"><a href="#" title="Scholarship" id="scholar">Scholarship</a></div>
            <?php endif; ?>
			<div id="qlink-container">
				<span class="gray">QUICK LINKS</span>
				<ul>
					<li class="active"><a href="/education-provider/<?php echo $eid; ?>" id="about">About<span></span></a></li>
					<li><a href="/education-location/<?php echo $eid; ?>" id="location-map">Location & Map</a></li>
				</ul>
			</div><!-- qlinks container-->
			<div class="advert-block border">
				<span class="gray">ADS YOU MAY BE INTERESTED IN</span>
			</div><!--advert block end-->
			<?php include_once "config/block_ads.php"; ?>
			<div class="advert-block border">
				<a href="#" class="blue thin">See your ad here »</a>
			</div><!--advert block end-->
		</div> <!-- left side-->
		<div id="content" class="content">
			<div class="item-info likes-big"><h1><?php echo $edudata['name']; ?></h1><div class="place-info"><?php echo $address; ?></div>
			<p style="width:500px;"><strong>Type:</strong>	<?php echo $edudata['type'];?>   
            <?php if(!empty($edudata['phone'])){echo "<strong>| Phone:</strong>";} ?> <?php echo $edudata['phone']; ?>  <?php if(!empty($edudata['enrollment'])){echo "<strong>| Enrollment:</strong>";} ?> <?php echo $edudata['enrollment']; ?></p>
			<span  id="like" status="add" class="likes-nr" style="cursor:pointer;"><?php echo $educlass->likecount($eid); ?></span>
			</div>
		

				<div class="edu-box border">
					<h2 class="black">About <?php echo $edudata['name']; ?></h2>
					<p><?php 
					if(empty($edudata['about'])){echo "<i>There is currently no information avaliable at this time.</i>";}
					else{echo nl2br($edudata['about']);} ?>
                    
                    </p>
				</div><!-- end edu box-->
				
				<div id="tabs">
<ul class="edu-tabs gradient">
<li><a href="#tabs-1" class="blue">Campus Photos (<?php echo $educlass->photocount($eid); ?>)</a><div class="vborder"></div></li>
<li><a href="#tabs-2" class="blue">Campus Video</a><div class="vborder"></div></li>
</ul>

<div id="tabs-2">
<div class="edu-photos">
<?php
if(empty($edudata['youtube'])){echo "<i>No video currently avaliable.</i>";}
else{$you = $edudata['youtube'];
	echo "<a target='_blank' href='$you'>$you</a>";}
?>
</div></div>



<div id="tabs-1">
				<div class="edu-photos">
				
			<?php
				if($educlass->photocount($eid) >= 1){
					$q = mysqli_query($dbc, "SELECT filename FROM eduphotos WHERE eduid='$eid' ORDER BY photoid DESC LIMIT 1");
					$img = mysqli_fetch_array($q);
					$filenamemain = $img['filename'];
					$filename = "/config/timthumb.php?src=/uploads/edu-images/$filenamemain&w=752&h=514&q=100&zc=2";
					$href = "/uploads/edu-images/$filenamemain";
					}
				else{$filename="/images/default-photo.png";$href="/images/default-photo.png";}
				?>
			<a href="<?php echo $href; ?>" id="image-big" data-lightbox="imagebig" title=""><img src="<?php echo $filename; ?>" id="edu-image" /></a>
								<div id="post-hr" style="width:100%; margin-bottom:15px; margin-top:5px;"></div><div style="clear:both"></div>

				<div id="thumbs">
                <?php
				$query = $educlass->photoget($eid);
				while($row=mysqli_fetch_array($query)){
					$filename = $row['filename'];
					$id = $row['photoid'];
					echo <<<END
									<img src="/config/timthumb.php?src=/uploads/edu-images/$filename&w=88&h=81&q=100" id="$id" onClick="mainimg('/config/timthumb.php?src=/uploads/edu-images/$filename&w=752&h=514&q=100&zc=2', '/uploads/edu-images/$filename')" class="photo_thumb2"/>

END;
				}
				
				
				
				?>
				
							
				</div>
				
				
				</div><!-- edu photos end-->

</div>



</div><!-- tabs end-->
				
				<div class="hborder"></div>
				
				<div class="edu-box">
					<h2 class="black">Reasons To Choose <?php echo $edudata['name']; ?></h2>
					<p><?php 
					if(empty($edudata['reasons'])){echo "<i>There is currently no information avaliable at this time.</i><br>
<br>";}
					else{echo nl2br($edudata['reasons']);} ?>
                    
                    </p>
				</div><!-- end edu box-->
				
				<div class="edu-box border">
					<div class="orange-button big-button"><a id="enroll" title="Enroll Now" href="#">Enroll Now</a></div>
				</div>
			
		</div><!-- content-->
			<?php include_once "education_right_block.php" ?>

	</article>
	<?php include_once "html_includes/footer.php" ?>
    </div>
    <?php if($uid != ""):?>
            <script>
			$(document).ready(function() 
{
	$('#like').die('click').live("click",function() 
{	
	var status = $(this).attr("status");

if(status == "add"){
	
var URL='/likeedu_ajax.php';
var dataString = 'eduid=' + <?php echo $eid;?>;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
$('#like').html(html)
$("#like").attr('status', 'liked');

}
 }
 });
}
return false;
});
});
</script>
<? endif; ?>
</body>