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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>My Albums | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>


<style>
input[type='date'],  input[type='text']{
	padding:5px 5px 4px;
	width:125px;
	margin-right:5px;
}</style>
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
	
			<div id="buttons-container">
				
				<div class="orange-button big-button">
					<a href="photos" class="bon-myphotos">My Photos</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="messages" class="b-inbox">Inbox</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="my-followers" class="b-myfollowers">My Followers</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="my-points" class="b-mypoints">My Points</a>
				</div>
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="blog-stats" class="b-blogstatistics">Blog Statistics</a>
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
			
<h1 class="my black">My Photo Albums</h1>
			
			<div id="my-info" class="gradient">
				
				
				<p class="info2">
				Total Albums<br />
				<span id="album-count"><?php echo mysqli_num_rows($Wall->AlbumGet($studentid)); ?></span>
				<b></b>
				</p>
				
				<div class="vborder"></div>
				
				<p class="info2">
				Total Photos<br />
				<span><?php echo $Wall->PhotoTotal($studentid); ?></span>
				</p>
				
				<div class="info2">
				Create New Album:<br />
				<input type="text" name="album-name" id="album-name" maxlength="60" /><button id="album-action" class="orange-button small-button">Create</button>
				</div>
				
				
			</div><!-- my info end-->
			
			<div id="photos">
				

				<?php
				$exec = $Wall->AlbumGet($studentid);
				while($row=mysqli_fetch_array($exec)){
					$id = $row['albumid'];
	$name = $row['albumname'];
	$count = $Wall->PhotoCount($id);
	if($count != 0){
	$q = mysqli_query($dbc, "SELECT filename FROM photos WHERE albumid='$id' ORDER BY photoid DESC LIMIT 1");
					$img = mysqli_fetch_array($q);
					$filename = $img['filename'];
					$div = "<img src='/config/timthumb.php?src=/uploads/user-imgs/$filename&w=143&h=181&q=80'>";
	}
	else{$div = '<img src="/images/default-album.png">';}
					echo <<<END
					<a href="/student/albums/$id" class="cool-border">
				$div
				<span>$name</span><span class="lgray">$count photos</span>
				</a>
					
END;
					
					
					
				}
				?>
				
				
				
				
				
				
				
				
				
			</div><!-- photos end-->
				
			</div><!-- content-->
		</div><!-- content-->
  </article>
           <script>
		
$(document).ready(function() 
{
$("#album-action").click(function() 
{
var albumval = $("#album-name").val();

var dataString = 'album='+ albumval;
if($.trim(albumval).length==0)
{
alert("Please enter an album name");
$("#album-name").focus();
}
else
{

$.ajax({
type: "POST",
url: "/addalbum_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$(html).hide().prependTo("#photos").fadeIn("slow");
var num = parseInt($('#album-count').html());
$('#album-count').html(num+1);
$("#album-name").val('').focus();
}
 });
}
return false;
	});




	
});

</script>
  <?php include_once "../html_includes/footer.php" ?></div>
</body>
</html>