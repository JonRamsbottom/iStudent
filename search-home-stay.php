<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
$user = new User();
$Wall = new Wall();
$uidsession = $_SESSION['uid'];
if(isset($_POST['search-submit'])){
		if($_SESSION['search-checksum'] == $_POST['search-checksum']){
			
$sql = "SELECT * FROM homestay WHERE ";

$where = array();

if (!empty($_POST['city']) && !preg_match('/\s/',$_POST['city'])) {
	$city = clean_data($_POST['city']);
    $where[] = "city LIKE '%$city%'";
}

if (!empty($_POST['scholarship'])) {
	$scholar = clean_data($_POST['scholarship']);
    $where[] = "scholarship = '$scholar'";
}
if (!empty($_POST['state'])) {
	$state = clean_data($_POST['state']);
    $where[] = "state = '$state'";
}
if (!empty($_POST['type'])) {
	$type = clean_data($_POST['type']);
    $where[] = "type = '$type'";
}
if (!empty($_POST['edu-id']) && !empty($_POST['edu'])) {
	$edu = clean_data($_POST['edu-id']);
    $where[] = "id = '$edu'";
}
	$sql .= implode(' AND ',$where);


	$_SESSION['sqlsearchhome'] = $sql;


		
		}
	
	
	
	
	}
elseif(isset($_SESSION['sqlsearchhome']) && !empty($_SESSION['sqlsearchhome']) && $_GET['recall'] == "Y" ){$sql = $_SESSION['sqlsearchhome']; }
$_SESSION['search-checksum'] = sha1(microtime());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Home Stay Families | iStudent</title>
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<?php include_once "html_includes/css.php" ?>
<link type="text/css" rel="stylesheet" media="all" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" charset="utf-8"/>

<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>
<script  src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
	
	$( "#date" ).datepicker({ dateFormat: "dd/mm/yy" });
	
  });
</script>



    
</head>

<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
		<div id="left2">
        	<h4>Search Criteria</h4>
            <form name="search" action="/search-home-stay" method="post">
                 <div class="form1">
                 		<label>State</label>
                        <select name="state">
                                <option value="">-- Please Select --</option>
                                <option value="NSW">NSW</option>
                                                                <option value="QLD">QLD</option>
                                                                                                <option value="ACT">ACT</option>

                                <option value="VIC">VIC</option>
                                <option value="TAS">TAS</option>
                                <option value="NT">NT</option>
                                <option value="WA">WA</option>
                                                                <option value="SA">SA</option>


                        </select>
                 </div>
                  <div class="form1">
                 		<label>City/Suburb</label>
                        <input name="city" type="text" value="" />
                 </div>
                 <div class="form12">
                        <label>Min Price ($AU)</label>
<input style="width:80px;float:left;" name="max" type="number" value="" />
                 </div>
                 <div class="form12">
                        <label>Max Price ($AU)</label>
                                                <input style="width:80px;float:left;" name="max" type="number" value="" />

                 </div>
                 <div class="form1">
                 		<label>Move In Date</label>
            <input type="text" id="date" name="date" value="" />
                 </div>
       			
                 <div class="form1">
                 		<label>Room Type</label>
                        <input type="radio" name="type" value="1" /> Entire home/apt<br />
                        <input type="radio" name="type" value="2" /> Private Room<br />
                        <input type="radio" name="type" value="3" /> Shared Room

                 </div>
                  <div class="form1">
                 		<label>Pets</label>
                        <input type="radio" name="pets" value="Y" /> Yes<br />
                        <input type="radio" name="pets" value="N" /> No<br />

                 </div>
                       <div class="form1">
                 		<label>Smoking Allowed</label>
                        <input type="radio" name="smoking" value="Y" /> Yes<br />
                        <input type="radio" name="smoking" value="N" /> No<br />

                 </div> 			
                 
                 <div class="form1">
                 		<button class="orange-button width100">Search Now</button>
                        <a href="/search-home-stay"><button type="button" class="orange-button width100">Reset Search</button></a>
                 </div>
                 <input type="hidden" name="search-submit" value="TRUE" /> <input type="hidden" name="search-checksum" value="<?php echo $_SESSION['search-checksum']; ?>" /> 
        </form>
        </div>
        <div id="right2">
            
          <?php
		  $sqlnew = $sql." LIMIT 300";
		  $exec = mysqli_query($dbc, $sqlnew);

		  if(mysqli_num_rows($exec) >= 1){
			  echo "<h4>".mysqli_num_rows($exec)." Home Stay Families found</h4>";
			  

	$total_pages = mysqli_num_rows($exec);
	$targetpage = "search-home-stay"; 	
	$limit = 15; 								
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
			$pagination.= "<a class='navtip' href=\"$targetpage?page=$prev&recall=Y\">Previous</a>";
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
					$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter&recall=Y\">$counter</a>";					
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
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter&recall=Y\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lpm1&recall=Y\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lastpage&recall=Y\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=1&recall=Y\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=2&recall=Y\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter&recall=Y\">$counter</a>";					
				}
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lpm1&recall=Y\">$lpm1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=$lastpage&recall=Y\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=1&recall=Y\">1</a>";
				$pagination.= "<a class='navtip number' href=\"$targetpage?page=2&recall=Y\">2</a>";
				$pagination.= "<a class='navtip number' href=\"#\">...</a>";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a class='navtip number active' href=\"#\">$counter</a>";
					else
						$pagination.= "<a class='navtip number' href=\"$targetpage?page=$counter&recall=Y\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class='navtip' href=\"$targetpage?page=$next&recall=Y\">Next >></a>";
		else
			$pagination.= "<a class='navtip' href=\"#\">Next >></a>";
		$pagination.= "</div>\n";		
	}
	
	$sql.= " LIMIT $start, $limit";
$exec = mysqli_query($dbc, $sql);			  
			  
			  
			  
			  
			  
			  while($row=mysqli_fetch_array($exec)){
				  $name = $row['name'];
				  $type = $row['type'];
				  $state = $row['state'];
				  $id = $row['id'];
				  $faceshtml = "";
				  $profile = $row['profile_picture'];
				  $rec = $educlass->likecount($id);
				  $scholar = $row['scholarship'];
				  if($scholar == "Y"){$scholar = "<div class='scholarship'></div>";}
				  else{$scholar = "";}
				  $about = substr($row['about'], 0, strrpos(substr($row['about'], 0, 150), ' '));
				  $faces = $educlass->usergrid($id, 10);
				  $q = mysqli_query($dbc, "SELECT filename FROM eduphotos WHERE eduid='$id' ORDER BY datecreated DESC LIMIT 1");
				  if(mysqli_num_rows($q) >= 1){$new = mysqli_fetch_array($q); $img=$new['filename']; 
				  $img="/config/timthumb.php?src=/uploads/edu-images/$img&w=205&h=135&q=90";}
				  else{$img = "/images/default-album.png";}
				  while($data=mysqli_fetch_array($faces)){
					  $fname = $data['firstname'];
					  $lname = $data['lastname'];
					  $sid = $data['dataid'];
					  $profile1 = $user->profilepicture($sid);
                      $faceshtml .= "<a href='/profile/$sid'><img src='/config/timthumb.php?src=$profile1&w=30&h=30&q=70' title='$fname $lname'></a>";
				  }
				  
				  
				  echo <<<END
				  <div class="containerbox">
            	<div class="searchboxx">
                    $scholar
                    <img src="$img">
                    <div class="logormit" style="background:url('config/timthumb.php?src=/uploads/edu/$profile&w=109&h=39&zc=2&q=100') no-repeat;"></div>
            	</div>
                <div class="infoboxx">
                    <h2>$name</h2>
                    <h6>$type > $state</h6>
                    <h3>$about</h3>
                    <div class="recss"><i class="recommendations"></i>$rec Recommendations</div>
            	</div>
                <div class="statboxx">
                    <h5>Students From This Institute</h5>
                    $faceshtml
                    <br>
                    
                    
                    <div class="greenstatbars">
                    	 
<a href="/education-provider/$id"><button class="orange-button">More Details</button></a>
                    </div>
            	</div>
            </div>
				  
END;
			  }
			  
			  
			  
			  
			  }
			  else{echo "<h4>0 Home Stay Families found</h4>";}

		  echo <<<END
		    <div id="friends-nav">
					<span></span>
					<div>
						$pagination
					</div>
		  </div><!-- friends nav end-->
		  
END;
		  
		  ?>  
       	  
            
            
          
          
          
         
            
            
            
            
                
                
                
        </div>
	</article>
<?php include_once "html_includes/footer.php" ?>
</div>

</body>
</html>