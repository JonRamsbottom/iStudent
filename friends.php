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
$uid = $studentid;
$Wall = new Wall();
$user = new User();
if($user->uidcheck($studentid) == false){header("Location: /index");exit;}
hitcounter($studentid, "profile-friends");

$profile = $user->profilepicture($studentid);
$userdata = $user->userdata($studentid);
$age = calcutateAge($userdata['dob']);

$friends = $Wall->GetFriends($uid);
				$friends = implode(',', $friends);
				$count = 0;
				if(isset($_POST['friend-search']) && !empty($_POST['friend-search']) && $_POST['friend-search'] != ""){
					$term = clean_data($_POST['friend-search']);
					$_SESSION['term-search'] = $term;
					$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((students.firstname LIKE '%$term%' OR students.lastname LIKE '%$term%') AND users.usernum IN ($friends))";
				}
				else if(isset($_SESSION['term-search']) && !empty($_SESSION['term-search']) && !empty($_POST['friend-search'])){
					$term = $_SESSION['term-search'];
				$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((students.firstname LIKE '%$term%' OR students.lastname LIKE '%$term%') AND users.usernum IN ($friends))";
				}
				else{
					$_SESSION['term-search'] = "";
				$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE users.usernum IN ($friends)";}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $userdata['firstname']. " ". $userdata['lastname']; ?> | Friends | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link rel="stylesheet"  href="/css/lean-slider.css" />
<link rel="stylesheet"  href="/css/slider.css" />
<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>


<script> var followinguser = 'false'; </script>
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
			$friendstatus = $Wall->FriendStatus($studentid, $_SESSION['uid']);
			if($friendstatus == "already"){echo "<a href='#' title='Friends' status='already' id='addfriend'>Friends</a>";}
			elseif($friendstatus == "request"){echo "<a href='#' title='Request Sent' status='request' id='addfriend'>Request Sent</a>";}
						elseif($friendstatus == "requested"){echo "<a href='#' title='Wants to be Friends' status='request' id='addfriend'>Requested</a>";}

			else{echo "<a href='#' title='Add Friend' status='add' id='addfriend'>Add Friend</a>";}
			?>
            
            
            </div>
            
            
			<div class="lgray-button big-button">
            <?php
			$followerstatus = $Wall->FollowerStatus($studentid, $_SESSION['uid']);
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
					<li ><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
					<li><a href="/offers/<?php echo $studentid; ?>" id="my-offers">My Offers</a></li>
					<li class="active"><a href="/friends/<?php echo $studentid; ?>" id="my-friends">My Friends (<?php echo $Wall->FriendCount($studentid);?>)</a></li>
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
<h1 class="my black">My Friends</h1>

<div id="invite">
				
				
				<div class="main-search">
				<form method="post" action="/friends/<?php echo $studentid; ?>">
					<button></button><input type="text" value="<?php echo $_SESSION['term-search']; ?>" name="friend-search" id="friend-search" placeholder="Search Friends by Name">
                </form>

				</div>
                <a href="/friends/<?php echo $studentid; ?>"><button style="margin-top:20px;" class="orange-button width100">Reset Search</button></a>

				
			</div>
			
			<div id="friends">
				<?php
				
				
				$total_pages = mysqli_num_rows(mysqli_query($dbc, $sql));
				
	$targetpage = "/friends/$studentid"; 	
	$limit = 16; 	
	$page = $_GET['page'];
		$adjacents = 3;

$page = preg_replace('/[^0-9.]+/', '', $page);
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	
	
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a class='navtip' href=\"$targetpage/$prev\">Previous</a>";
		else
			$pagination.= "<a class='navtip' href=\"#\">Previous</a>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
				else
					$pagination.= "<a class='navtip number' href=\"$targetpage/$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage/$counter\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				$pagination.= "<a class='navtip number' href=\"$targetpage/$lpm1\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage/$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage/1\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage/2\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage/$counter\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage/$lpm1\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage/$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage/1\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage/2\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage/$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class='navtip' href=\"$targetpage/$next\">Next >></a>";
		else
			$pagination.= "<a class='navtip' href=\"#\">Next >></a>";
		$pagination.= "</div>\n";		
	}
	
	$sql.= " LIMIT $start, $limit";
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
						<a href="/student/messages/$id"><div class="green-button small-button"><span class="small-message" style="color:#FFF">Message Me</span></div></a>
						
					</div><!-- friends box end-->




END;



					
					if($count % 2 == 0){echo "</div>";}

					
				}
				
				?>
				
					
				
				<br />
				<div id="friends-nav">
					<div>
                    <?php echo $pagination; ?>
					</div>
				</div><!-- friends nav end-->
				
			</div><!-- friends end-->
				
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