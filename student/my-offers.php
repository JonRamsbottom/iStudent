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
<title>My Offers | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>



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
					<li ><a href="home" id="wall">My Wall</a></li>
					<li><a href="dashboard" id="my-dashboard">My Dashboard</a></li>
					<li><a href="about-me" id="about-me">About Me</a></li>
					<li><a href="photos" id="my-photos">My Photos</a></li>
					<li class="active"><a href="my-offers" id="my-offers">My Offers</a></li>
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
					<p>Here you can post services that you can offer to other students. Use the fields below to do this.</p>
      </div>
		<div style="clear:both"></div>
			<div id="wall-post">
				<form action="" type="" class="post-form">
                <select class="input-border gray" name="offer" id="offer" style="width:570px;">
                <option value="">-- Please Select --</option>
                <option value="Airport pickup">Airport pickup</option>
                                <option value="Show around my city">Show around my city</option>
                <option value="Personalised education support">Personalised education support</option>
                <option value="Accommodation">Accommodation</option>

                </select>
					<textarea name="offertext" id="offertext" class="input-border gray" placeholder="Description about your offer"></textarea>
					<div id="tab-arrow-4"><span></span></div>


                







					<ul>
						<li id="wall-textb"><a href="#"><span class="gray">TEXT</span></a></li>
						
					</ul>
					
					<button id="post-action" class="orange-button small-button">Post Offer</button>
				</form>
			<br /><br />
<br />


                                
            <script>
		
$(document).ready(function() 
{
$("#post-action").click(function() 
{
var offerval = $("#offer").val();
var offertextval = $("#offertext").val();

var dataString = 'offer='+ offerval+'&offertext='+offertextval+'&student=<?php echo $studentid; ?>';
if($.trim(offerval).length==0)
{
alert("Please select an offer");
}
else if($.trim(offertextval).length==0)
{
alert("Please enter a description of your offer");
}
else
{

$.ajax({
type: "POST",
url: "/addoffers_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$(html).hide().prependTo("#content-post1").fadeIn("slow");
$("#offertext").val('').focus();	
$("#offer").val('').focus();	
}
 });
}
return false;
	});
});

</script>
            
            
			<div id="main-post">

				<div id="post-hr"></div>
					
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
			
			
			
		</div><!-- content-->

		<?php include_once "right_side_block.php"; ?>
  </article>
  <?php include_once "../html_includes/footer.php" ?></div>
</body>
</html>