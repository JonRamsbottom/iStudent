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
    <title><?php echo $edudata['name']; ?> | Location | iStudent</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link href="/css/jquery-ui2.css" rel="stylesheet" />
<link href="/css/lightbox.css" rel="stylesheet" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>


<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script>
      var geocoder;
      var map;
      function initialize() {
        geocoder = new google.maps.Geocoder();
		var address = "<?php echo $address; ?>, Australia";
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
          } else {
            //alert('Geocode was not successful for the following reason: ' + status);
          }
        });
        
        var mapOptions = {
          zoom: 15,
          
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
      }

   
    </script> 
</head>
<body onload="initialize()">
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
					<li ><a href="/education-provider/<?php echo $eid; ?>" id="about">About<span></span></a></li>
					<li class="active"><a href="/education-location/<?php echo $eid; ?>" id="location-map">Location & Map</a></li>
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
					<h2 class="black">Location of Education Provider</h2>
 <?php
													   if(!empty($edudata['street'])){echo '<div id="map_canvas" style="width:500px; height:500px;">';}
													   else{echo "<i>Address information is not avaliable</i>";}
													   ?>
				</div><!-- end edu box-->				

                    				                  
													    

				
				
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