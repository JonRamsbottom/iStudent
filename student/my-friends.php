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
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title>My Friends | iStudent</title>
<?php include_once "../html_includes/css.php" ?>

<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>

<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId:'472036489547361',
cookie:true,
status:true,
xfbml:true
});

function FacebookInviteFriends()
{
FB.ui({
method: 'apprequests',
message: 'Visit the iStudent Website to connect with students from all over the world.'
});
}
</script>



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
					<li class="active"> <a href="my-friends" id="my-friends">My Friends (<?php echo $Wall->FriendCount($uid); ?>)</a></li>
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
		<div id="invite">
				<form id="invite-form">
				<h2>Invite your friends to iStudent</h2>
				<label for="inviteface" class="gray">Facebook Friends:</label><a href="#" onclick="FacebookInviteFriends();"><button type="button" name="invite-face" id="inviteface"><img src="/img/face_but.jpg" /></button></a><label class="gray" for="faceemails">Enter:</label><input name="faceemails" type="text" class="input-border gray" placeholder="Email Address" ><button>Invite</button>
				</form>
				
				<div class="main-search">
				<form method="post" action="my-friends">
					<button></button><input type="text" value="<?php echo $_SESSION['term-search']; ?>" name="friend-search" id="friend-search" placeholder="Search Friends by Name">
                </form>

				</div>
                <a href="my-friends"><button style="margin-top:20px;" class="orange-button width100">Reset Search</button></a>

				
			</div>
			
			<div id="friends">
				<?php
				
				
				$total_pages = mysqli_num_rows(mysqli_query($dbc, $sql));
				
	$targetpage = "my-friends"; 	
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
			$pagination.= "<a class='navtip' href=\"$targetpage?page=$prev\">Previous</a>";
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
					$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter\">$counter</a>";					
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
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class='navtip' href=\"$targetpage?page=$next\">Next >></a>";
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
						<a href="/student/messages/$id"><div class="green-button small-button"><span style='color:#FFF' class="small-message">Message Me</span></div></a>
						
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

	</article>
    <?php include_once "../html_includes/footer.php" ?></div>
</body>
</html>