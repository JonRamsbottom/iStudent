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


				$follow = $Wall->GetFollowers($uid);
				$follow = implode(',', $follow);
				$count = 0;
				if(isset($_POST['follower-search']) && !empty($_POST['follower-search']) && $_POST['follower-search'] != ""){
					$term = clean_data($_POST['follower-search']);
					$_SESSION['term-search-follower'] = $term;
					$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((students.firstname LIKE '%$term%' OR students.lastname LIKE '%$term%') AND users.usernum IN ($follow))";
				}
				else if(isset($_SESSION['term-search-follower']) && !empty($_SESSION['term-search-follower']) && !empty($_POST['follower-search'])){
					$term = $_SESSION['term-search-follower'];
				$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ((firstname LIKE '%$term%' OR lastname LIKE '%$term%') AND users.usernum IN ($follow))";
				}
				else{
					$_SESSION['term-search-follower'] = "";
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
<title>My Followers | iStudent</title>
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
				<div class="orange-button big-button">
					<a href="" class="bon-myfollowers">My Followers</a>
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
			<h1 class="my black">My Followers</h1>
			
			<div id="my-info">
				
				
				<p class="info1">
				Total Followers<br />
				<span><?php echo $Wall->FollowerCount($studentid); ?></span>
				</p>
				
				<p class="info1">
				
				</p>
				
				<p class="info1">
					<strong>Want More Followers?</strong><br />
					Post your iStudent profile blog on local blog sites. This often brings people to your iStudent profile, therefore it helps to increase your followers.
				</p>
				<div class="border"></div>
				
				<div class="main-search">
				<form type="" method="post" action="my-followers">
					<button></button><input type="text" name="follower-search" id="follower-search" value="<?php echo $_SESSION['term-search-follower']; ?>" placeholder="Find Followers by Name">
				</form>
				</div>
				                <a href="my-followers"><button style="margin-top:20px;" class="orange-button width100">Reset Search</button></a>

			</div><!-- my info end-->
			
			<div id="friends">
				<?php
				
				
				$total_pages = mysqli_num_rows(mysqli_query($dbc, $sql));
				
	$targetpage = "my-followers"; 	
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
	
	$sql.= "ORDER BY firstname LIMIT $start, $limit ";
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
  $followerstatus = $Wall->FollowerStatus($id, $studentid);
					if($followerstatus == "true"){$follow = "Following";$status="status='following'";}
					else{$follow = "Follow Me"; $status="status='add'";}
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
							<li>Followers (<span id="followcount_$id">$follower</span>)</li>
							<li>Thanks ($thanks)</li>
							<li>Profile Completion (100%)</li>
							
$countryrow						</ul>
						</div>
						<p></p>
						<a href="/student/messages/$id"><div class="green-button small-button"><span style='color:#FFF' class="small-message">Message Me</span></div></a>
												<div class="followme lgray-button small-button" id="following_$id" userid="$id" $status><span id='follow_$id' class="small-fallow">$follow</span></div>

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
   <script>
			$(document).ready(function() 
{
	$('.followme').die('click').live("click",function() 
{	
	var status = $(this).attr("status");
		var userid = $(this).attr("userid");

if(status == "add"){
var URL='/addfollower_ajax.php';
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
	$("#following_"+userid).attr('status', 'following');
	var num = parseInt($('#followcount_'+userid).html());
$('#followcount_'+userid).html(num+1);
$("#follow_"+userid).html("Following");
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