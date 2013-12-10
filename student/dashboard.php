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

$au = $Wall->ViewCountCountry($studentid, "AU", "");
$us = $Wall->ViewCountCountry($studentid, "US", "");
$cn = $Wall->ViewCountCountry($studentid, "CN", "");
$jp = $Wall->ViewCountCountry($studentid, "JP", "");
$other = $Wall->ViewCountCountry($studentid, "", "");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>My Dashboard | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

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
	
			<div id="buttons-container">
				
				<div class="lgray-button big-button" onmouseover="this.className='orange-button big-button';" onmouseout="this.className='lgray-button big-button';">
					<a href="photos" class="b-myphotos">My Photos</a>
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
			<h1 class="my black">My Dashboard</h1>
			
			<div id="my-info">
				
				
				<p class="info6">
				Unique Profile Views<br />
				<span><?php echo $Wall->ViewCount($studentid); ?></span>
				</p>
				
				<p class="info6">
				Total Points<br />
				<span>0</span>
				</p>
                
				<p class="info6">
				Total Followers<br />
				<span><?php echo $Wall->FollowerCount($studentid); ?></span>
				</p>

				<div class="border"></div>
				

				
			</div><!-- my info end-->
			
			<div id="breakdownday">
				
				<div class="statisticsy">
                
                     <h2>Break down by Visitor Country</h2>
                <br/>
					
                    <div class="visitorcountrybox">
                    	<h5>Where The Profile Visits Came From ?</h5>
                    	<br>
                                <div class="visitbarbox"><div class="visitbox100">Australia</div><div class="visitbox570"><div class="visitbar" style="width:<?php if(intval($au) >= 100){echo "100";} else {echo $au;}?>%; background:#4d8ddc; display:block; height:8px;"></div></div><div class="visitbox30"><?php echo $au; ?></div></div>
                                <div class="visitbarbox"><div class="visitbox100">United States</div><div class="visitbox570"><div class="visitbar" style="width:<?php if(intval($us) >= 100){echo "100";} else {echo $us;}?>%; background:#56c9da; display:block; height:8px;"></div></div><div class="visitbox30"><?php echo $us ?></div></div>
                                <div class="visitbarbox"><div class="visitbox100">China</div><div class="visitbox570"><div class="visitbar" style="width:<?php if(intval($cn) >= 100){echo "100";} else {echo $cn;}?>%; background:#de6b54; display:block; height:8px;"></div></div><div class="visitbox30"><?php echo $cn ?></div></div>
                                <div class="visitbarbox"><div class="visitbox100">Japan</div><div class="visitbox570"><div class="visitbar" style="width:<?php if(intval($jp) >= 100){echo "100";} else {echo $jp;}?>%; background:#c07acb; display:block; height:8px;"></div></div><div class="visitbox30"><?php echo $jp ?></div></div>
                                <div class="visitbarbox"><div class="visitbox100">Other Countries</div><div class="visitbox570"><div class="visitbar" style="width:<?php if(intval($other) >= 100){echo "100";} else {echo $other;}?>%; background:#a7cb7a; display:block; height:8px;"></div></div><div class="visitbox30"><?php echo $other; ?></div></div>
                    </div>
				</div><!-- friends box end-->
					
                    
                     
					
                    
                    
                    
                    
      </div>
				
			</div><!-- content-->
		</div><!-- content-->

	</article>
    <?php include_once "../html_includes/footer.php" ?></div>
</body>
</html>