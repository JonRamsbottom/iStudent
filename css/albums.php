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


$album = clean_data($_GET['album_id']);
if($Wall->AlbumGetData($album, $studentid) == 0){header("Location: student/home");}
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
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>My Photos | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery-ui.min.js"></script>
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.wallform.js"></script>
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
</head>

<body>
<div id="containbody">
<?php include_once "../html_includes/header.php" ?>
<article>
		<div id="left">
			<div class="cool-border">
				<img src="<?php echo $profile; ?>" class="to-change"/>
				<a href="#" class="gray2">Change Profile Picture</a>
			</div>
	
			<div id="buttons-container">
				
				<div class="orange-button big-button">
					<a href="/student/photos" class="bon-myphotos">My Photos</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="/student/messages" class="b-inbox">Inbox</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="/student/my-followers" class="b-myfollowers">My Followers</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="/student/my-points" class="b-mypoints">My Points</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="/student/blog-stats" class="b-blogstatistics">Blog Statistics</a>
				</div>
			</div><!-- buttons container-->
			
			<div class="advert-block border">
				<span class="gray">ADS YOU MAY BE INTERESTED IN</span>
			</div><!--advert block end-->
		  <?php include_once "../config/block_ads.php"; ?>
			<div class="advert-block border">
				<a href="#" class="blue thin">See your ad here »</a>
			</div><!--advert block end-->
		</div> <!-- left side-->
	<div id="content-long" class="content">
			
<h1 class="my black">My Photos - <?php echo $albumname; ?></h1>
			
			<div id="my-info" class="gradient">
				
				
				<p class="info2">
				Total Albums<br />
				<span id="album-count"><?php echo mysqli_num_rows($Wall->AlbumGet($studentid)); ?></span>
				</p>
				
				<div class="vborder"></div>
				
				<p class="info2">
				Photos in Album<br />
				<span id="photo-count"><?php echo $count; ?></span>
                				<b></b>
				</p>
				
			  <div class="info2">
				<strong>Upload Images:</strong><br /><br />
                <form id="imageupload" method="post" enctype="multipart/form-data" action='/image_upload_ajax.php'> 
<div id='preview'>
</div>
<div id='imageloadstatus' style="display:none;">
<img src='http://istudent.blakebytes.com.au/testistudent/wall_icons/ajaxloader.gif'/> Uploading please wait ....
</div>
<div id='imageloadbutton'>
				<input type="file" name="image-upload" id="image-upload" />
                <input type="hidden" id="album" name="album" value="<?php echo $album; ?>" />
</div>
				</form>
              </div>
				
				
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
				else{$filename="";$href="";}
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
           <script>
		
$(document).ready(function() 
{
$('#image-upload').die('click').live('change', function()			
{ 
$("#imageupload").ajaxForm({
	target: '#thumbs', 
     beforeSubmit:function(){ 
	 $("#imageloadstatus").show();
	 $("#imageloadbutton").hide();
	 }, 
	success:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	 $('#image-upload').val('');
	 var num = parseInt($('#photo-count').html());
$('#photo-count').html(num+1);

	}, 
	error:function(){ 
	 $("#imageloadstatus").hide();
	 $("#imageloadbutton").show();
	} }).submit();



});
	
});

</script>
  <?php include_once "../html_includes/footer.php" ?></div>
</body>
</html>