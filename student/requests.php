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


				$requests = $Wall->FriendRequestData($uid);
				$follow = implode(',', $requests);
				$count = 0;
				if(isset($_POST['request-search']) && !empty($_POST['request-search']) && $_POST['request-search'] != ""){
					$term = clean_data($_POST['request-search']);
					$_SESSION['term-search-request'] = $term;
					$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((students.firstname LIKE '%$term%' OR students.lastname LIKE '%$term%') AND users.usernum IN ($follow))";
				}
				else if(isset($_SESSION['term-search-request']) && !empty($_SESSION['term-search-request']) && !empty($_POST['request-search'])){
					$term = $_SESSION['term-search-request'];
				$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((students.firstname LIKE '%$term%' OR students.lastname LIKE '%$term%') AND users.usernum IN ($follow))";
				}
				else{
					$_SESSION['term-search-request'] = "";
				$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE users.usernum IN ($follow)";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>Friend Requests | iStudent</title>
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
	
			<div id="qlink-container">
				<span class="gray">QUICK LINKS</span>
				<ul>
					<li><a href="home" id="wall">My Wall</a></li>
					<li><a href="dashboard" id="my-dashboard">My Dashboard</a></li>
					<li><a href="about-me" id="about-me">About Me</a></li>
					<li><a href="photos" id="my-photos">My Photos</a></li>
					<li><a href="my-offers" id="my-offers">My Offers</a></li>
					<li> <a href="my-friends" id="my-friends">My Friends (<strong id="friend-main2"><?php echo $Wall->FriendCount($uid); ?></strong>)</a></li>
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
			<h1 class="my black">Friend Requests</h1>
			
			<div id="my-info">
				
				
				<p class="info1" style="width:auto;">
				Total Friend Requests<br />
				<span class="friend-request-span"><?php echo $Wall->FriendRequestCount($studentid); ?></span>
				</p>
				
				<p class="info1">
				
				</p>
				
				<div class="border"></div>
				
				<div class="main-search">
				<form type="" method="post" action="requests">
					<button></button><input type="text" name="request-search" id="request-search" value="<?php echo $_SESSION['term-search-request']; ?>" placeholder="Find Requests by Name">
				</form>
				</div>
				                <a href="requests"><button style="margin-top:20px;" class="orange-button width100">Reset Search</button></a>

			</div><!-- my info end-->
			
			<div id="friends">
				<?php
				
				
				
	
$sql.= "ORDER BY firstname";
$exec = mysqli_query($dbc, $sql);			  
			  
				
				while($row=mysqli_fetch_array($exec)){
					$countryrow = "";
					$follower = $Wall->FollowerCount($row['usernum']);
					$fname = $row['firstname'];
					$lname = $row['lastname'];
					$uni = "";
					$country = $row['country'];
					$id = $row['usernum'];
					if(!empty($country)){
						$image = "/images/flags/$country.png";
					    $cname = $user->countrycode($country);
						$countryrow="<li class='country' style=\"list-style-image: url('$image');\">$cname</li>";}
					else{$countryrow="<li class='country' ></li>";}
					if(!empty($row['educationprovider'])){
						$uni = $user->eduprovidertype($row['educationprovider'])." - ".$user->eduprovider($row['educationprovider']);
						}
					$profile = $user->profilepicture($row['usernum']);
$age = calcutateAge($row['dob']);
$thanks = $Wall->ThanksCount($row['usernum']);
  
					
					$count++;

					if($count % 2 == 1 && $count!=1){echo "<div class='two-friends-box shadow-border'>";}
					elseif($count == 1){echo "<div class='two-friends-box'>";}
					
echo <<<END
<div class="friends-box">
										
						<img width="144" height="151" src="/config/timthumb.php?src=$profile&w=144&h=151&q=100&s=1" />
						
						<div class="friends-info">
						<a href="/profile/$id"><h3 style="height:auto; margin-bottom:5px;" class="black">$fname $lname, $age</h3></a>
						<span class="gray2">$uni</span>
						<ul>
							<li>Followers ($follower)</li>
							<li>Thanks ($thanks)</li>
							<li>Profile Completion (100%)</li>
							
$countryrow						</ul>
						</div>
						<p></p>
						<a href="/student/messages/$id"><div class="green-button small-button"><span style="color:#FFF" class="small-message">Message Me</span></div></a>
												<div class="accept lgray-button small-button" userid="$id" status="add"><span id='accept_$id' class="small-fallow">Accept Request</span></div>

					</div><!-- friends box end-->




END;



					
					if($count % 2 == 0){echo "</div>";}

					
				}
				
				?>
				
					
				
				<br />
				
				
			</div><!-- friends end-->
			
			
		</div><!-- content-->

  </article>
  <?php include_once "../html_includes/footer.php" ?></div>
   <script>
			$(document).ready(function() 
{
	$('.accept').die('click').live("click",function() 
{	
	var status = $(this).attr("status");
		var userid = $(this).attr("userid");

if(status == "add"){
var URL='/acceptrequest_ajax.php';
var dataString = 'studentid=' + userid;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){
if(html)
{
if(html == "true"){
$("#accept_"+userid).html("Friends").attr('status', 'friends');
var num = parseInt($('#friend-main2').html());
$('#friend-main2').html(num+1);
}
}
 }
 });
}
return false;
});
});
</script>
</body>
</html>