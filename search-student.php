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
			
$sql = "SELECT students.*,users.usernum FROM students LEFT JOIN users ON students.dataid=users.data_id WHERE ";

$where = array();

if (!empty($_POST['fname']) && !preg_match('/\s/',$_POST['fname'])) {
	$fname = clean_data($_POST['fname']);
    $where[] = "students.firstname LIKE '%$fname%'";
}

if (!empty($_POST['lname']) && !preg_match('/\s/',$_POST['lname'])) {
	$lname = clean_data($_POST['lname']);
    $where[] = "students.lastname LIKE '%$lname%'";
}
if (!empty($_POST['gender'])) {
	$gender = clean_data($_POST['gender']);
    $where[] = "students.gender = '$gender'";
}
if (!empty($_POST['state'])) {
	$state = clean_data($_POST['state']);
    $where[] = "students.state = '$state'";
}
if (!empty($_POST['suburb']) && !preg_match('/\s/',$_POST['suburb'])) {
	$suburb = clean_data($_POST['suburb']);
    $where[] = "students.suburb LIKE '%$suburb%'";
}
if (!empty($_POST['time_aus'])) {
	$time_aus = clean_data($_POST['time_aus']);
    $where[] = "time_australia = '$time_aus'";
}
if (!empty($_POST['country'])) {
	$country = clean_data($_POST['country']);
    $where[] = "country = '$country'";
}
if (!empty($_POST['edu-id']) && !empty($_POST['edu'])) {
	$edu = clean_data($_POST['edu-id']);
    $where[] = "educationprovider = '$edu'";
}
	$sql .= implode(' AND ',$where);

	$sql .= " AND users.active=1 AND users.usernum!='$uidsession'";

	$_SESSION['sqlsearch'] = $sql;

header("Location: search-student?recall=Y");
exit;
		
		}
	
	
	
	
	}
elseif(isset($_SESSION['sqlsearch']) && !empty($_SESSION['sqlsearch']) && $_GET['recall'] == "Y" ){$sql = $_SESSION['sqlsearch']; }
$_SESSION['search-checksum'] = sha1(microtime());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Students | iStudent</title>
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
	
	//autocomplete
	$(".auto").autocomplete({
		source: "eduprovider.php",
		minLength: 3,
		select: function(event, ui) {
            $("#edu").val(ui.item.label);
            $("#edu-id").val(ui.item.value);
            return false;
        }
    });
  });
</script>

    <style>
	 .ui-autocomplete {
    max-height: 400px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }</style>
</head>

<body>
<div id="containbody">
<?php include_once "html_includes/header.php" ?>
<article>
		<div id="left2">
        	<h4>Search Criteria</h4>
            <form name="search" action="/search-student" method="post">
                 <div class="form1">
                 		<label>First Name</label>
                        <input name="fname" type="text" value="" />
                 </div>
                  <div class="form1">
                 		<label>Last Name</label>
                        <input name="lname" type="text" value="" />
                 </div>
                 <div class="form1">
                 		<label>Country Of Origin</label>
                        <select name="country">
                                <option value="">-- Please Select --</option>
<option value="af">Afghanistan</option>
<option value="ax">Åland Islands</option>
<option value="al">Albania</option>
<option value="dz">Algeria</option>
<option value="as">American Samoa</option>
<option value="ad">Andorra</option>
<option value="ao">Angola</option>
<option value="ai">Anguilla</option>
<option value="aq">Antarctica</option>
<option value="ag">Antigua and Barbuda</option>
<option value="ar">Argentina</option>
<option value="am">Armenia</option>
<option value="aw">Aruba</option>
<option value="au">Australia</option>
<option value="at">Austria</option>
<option value="az">Azerbaijan</option>
<option value="bs">Bahamas</option>
<option value="bh">Bahrain</option>
<option value="bd">Bangladesh</option>
<option value="bb">Barbados</option>
<option value="by">Belarus</option>
<option value="be">Belgium</option>
<option value="bz">Belize</option>
<option value="bj">Benin</option>
<option value="bm">Bermuda</option>
<option value="bt">Bhutan</option>
<option value="bo">Bolivia</option>
<option value="ba">Bosnia and Herzegovina</option>
<option value="bw">Botswana</option>
<option value="bv">Bouvet Island</option>
<option value="br">Brazil</option>
<option value="io">British Indian Ocean Territory</option>
<option value="bn">Brunei Darussalam</option>
<option value="bg">Bulgaria</option>
<option value="bf">Burkina Faso</option>
<option value="bi">Burundi</option>
<option value="kh">Cambodia</option>
<option value="cm">Cameroon</option>
<option value="ca">Canada</option>
<option value="cv">Cape Verde</option>
<option value="ky">Cayman Islands</option>
<option value="cf">Central African Republic</option>
<option value="td">Chad</option>
<option value="cl">Chile</option>
<option value="cn">China</option>
<option value="cx">Christmas Island</option>
<option value="cc">Cocos (Keeling) Islands</option>
<option value="co">Colombia</option>
<option value="km">Comoros</option>
<option value="cg">Congo</option>
<option value="cd">Congo, The Democratic Republic of The</option>
<option value="ck">Cook Islands</option>
<option value="cr">Costa Rica</option>
<option value="ci">Cote D'ivoire</option>
<option value="hr">Croatia</option>
<option value="cu">Cuba</option>
<option value="cy">Cyprus</option>
<option value="cz">Czech Republic</option>
<option value="dk">Denmark</option>
<option value="dj">Djibouti</option>
<option value="dm">Dominica</option>
<option value="do">Dominican Republic</option>
<option value="ec">Ecuador</option>
<option value="eg">Egypt</option>
<option value="sv">El Salvador</option>
<option value="gq">Equatorial Guinea</option>
<option value="er">Eritrea</option>
<option value="ee">Estonia</option>
<option value="et">Ethiopia</option>
<option value="fk">Falkland Islands (Malvinas)</option>
<option value="fo">Faroe Islands</option>
<option value="fj">Fiji</option>
<option value="fi">Finland</option>
<option value="fr">France</option>
<option value="gf">French Guiana</option>
<option value="pf">French Polynesia</option>
<option value="tf">French Southern Territories</option>
<option value="ga">Gabon</option>
<option value="gm">Gambia</option>
<option value="ge">Georgia</option>
<option value="de">Germany</option>
<option value="gh">Ghana</option>
<option value="gi">Gibraltar</option>
<option value="gr">Greece</option>
<option value="gl">Greenland</option>
<option value="gd">Grenada</option>
<option value="gp">Guadeloupe</option>
<option value="gu">Guam</option>
<option value="gt">Guatemala</option>
<option value="gg">Guernsey</option>
<option value="gn">Guinea</option>
<option value="gw">Guinea-bissau</option>
<option value="gy">Guyana</option>
<option value="ht">Haiti</option>
<option value="hm">Heard Island and Mcdonald Islands</option>
<option value="va">Holy See (Vatican City State)</option>
<option value="hn">Honduras</option>
<option value="hk">Hong Kong</option>
<option value="hu">Hungary</option>
<option value="is">Iceland</option>
<option value="in">India</option>
<option value="id">Indonesia</option>
<option value="ir">Iran, Islamic Republic of</option>
<option value="iq">Iraq</option>
<option value="ie">Ireland</option>
<option value="im">Isle of Man</option>
<option value="il">Israel</option>
<option value="it">Italy</option>
<option value="jm">Jamaica</option>
<option value="jp">Japan</option>
<option value="je">Jersey</option>
<option value="jo">Jordan</option>
<option value="kz">Kazakhstan</option>
<option value="ke">Kenya</option>
<option value="ki">Kiribati</option>
<option value="kp">Korea, Democratic People's Republic of</option>
<option value="kr">Korea, Republic of</option>
<option value="kw">Kuwait</option>
<option value="kg">Kyrgyzstan</option>
<option value="la">Lao People's Democratic Republic</option>
<option value="lv">Latvia</option>
<option value="lb">Lebanon</option>
<option value="ls">Lesotho</option>
<option value="lr">Liberia</option>
<option value="ly">Libyan Arab Jamahiriya</option>
<option value="li">Liechtenstein</option>
<option value="lt">Lithuania</option>
<option value="lu">Luxembourg</option>
<option value="mo">Macao</option>
<option value="mk">Macedonia, The Former Yugoslav Republic of</option>
<option value="mg">Madagascar</option>
<option value="mw">Malawi</option>
<option value="my">Malaysia</option>
<option value="mv">Maldives</option>
<option value="ml">Mali</option>
<option value="mt">Malta</option>
<option value="mh">Marshall Islands</option>
<option value="mq">Martinique</option>
<option value="mr">Mauritania</option>
<option value="mu">Mauritius</option>
<option value="yt">Mayotte</option>
<option value="mx">Mexico</option>
<option value="fm">Micronesia, Federated States of</option>
<option value="md">Moldova, Republic of</option>
<option value="mc">Monaco</option>
<option value="mn">Mongolia</option>
<option value="me">Montenegro</option>
<option value="ms">Montserrat</option>
<option value="ma">Morocco</option>
<option value="mz">Mozambique</option>
<option value="mm">Myanmar</option>
<option value="na">Namibia</option>
<option value="nr">Nauru</option>
<option value="np">Nepal</option>
<option value="nl">Netherlands</option>
<option value="an">Netherlands Antilles</option>
<option value="nc">New Caledonia</option>
<option value="nz">New Zealand</option>
<option value="ni">Nicaragua</option>
<option value="ne">Niger</option>
<option value="ng">Nigeria</option>
<option value="nu">Niue</option>
<option value="nf">Norfolk Island</option>
<option value="mp">Northern Mariana Islands</option>
<option value="no">Norway</option>
<option value="om">Oman</option>
<option value="pk">Pakistan</option>
<option value="pw">Palau</option>
<option value="ps">Palestinian Territory, Occupied</option>
<option value="pa">Panama</option>
<option value="pg">Papua New Guinea</option>
<option value="py">Paraguay</option>
<option value="pe">Peru</option>
<option value="ph">Philippines</option>
<option value="pn">Pitcairn</option>
<option value="pl">Poland</option>
<option value="pt">Portugal</option>
<option value="pr">Puerto Rico</option>
<option value="qa">Qatar</option>
<option value="re">Reunion</option>
<option value="ro">Romania</option>
<option value="ru">Russian Federation</option>
<option value="rw">Rwanda</option>
<option value="sh">Saint Helena</option>
<option value="kn">Saint Kitts and Nevis</option>
<option value="lc">Saint Lucia</option>
<option value="pm">Saint Pierre and Miquelon</option>
<option value="vc">Saint Vincent and The Grenadines</option>
<option value="ws">Samoa</option>
<option value="sm">San Marino</option>
<option value="st">Sao Tome and Principe</option>
<option value="sa">Saudi Arabia</option>
<option value="sn">Senegal</option>
<option value="rs">Serbia</option>
<option value="sc">Seychelles</option>
<option value="sl">Sierra Leone</option>
<option value="sg">Singapore</option>
<option value="sk">Slovakia</option>
<option value="si">Slovenia</option>
<option value="sb">Solomon Islands</option>
<option value="so">Somalia</option>
<option value="za">South Africa</option>
<option value="gs">South Georgia and The South Sandwich Islands</option>
<option value="es">Spain</option>
<option value="lk">Sri Lanka</option>
<option value="sd">Sudan</option>
<option value="sr">Suriname</option>
<option value="sj">Svalbard and Jan Mayen</option>
<option value="sz">Swaziland</option>
<option value="se">Sweden</option>
<option value="ch">Switzerland</option>
<option value="sy">Syrian Arab Republic</option>
<option value="tw">Taiwan, Province of China</option>
<option value="tj">Tajikistan</option>
<option value="tz">Tanzania, United Republic of</option>
<option value="th">Thailand</option>
<option value="tl">Timor-leste</option>
<option value="tg">Togo</option>
<option value="tk">Tokelau</option>
<option value="to">Tonga</option>
<option value="tt">Trinidad and Tobago</option>
<option value="tn">Tunisia</option>
<option value="tr">Turkey</option>
<option value="tm">Turkmenistan</option>
<option value="tc">Turks and Caicos Islands</option>
<option value="tv">Tuvalu</option>
<option value="ug">Uganda</option>
<option value="ua">Ukraine</option>
<option value="ae">United Arab Emirates</option>
<option value="gb">United Kingdom</option>
<option value="us">United States</option>
<option value="um">United States Minor Outlying Islands</option>
<option value="uy">Uruguay</option>
<option value="uz">Uzbekistan</option>
<option value="vu">Vanuatu</option>
<option value="ve">Venezuela</option>
<option value="vn">Viet Nam</option>
<option value="vg">Virgin Islands, British</option>
<option value="vi">Virgin Islands, U.S.</option>
<option value="wf">Wallis and Futuna</option>
<option value="eh">Western Sahara</option>
<option value="ye">Yemen</option>
<option value="zm">Zambia</option>
<option value="zw">Zimbabwe</option>


                        </select>
                 </div>
       			
                 <div class="form1">
                 		<label>Gender</label>
                        <input type="radio" name="gender" value="M" /> M
                        <input type="radio" name="gender" value="F" /> F
                 </div>
                 <div class="form1">
                 		<label>Time in Australia</label>
                        <select name="time_aus" id="time_aus">
                                                        <option value="">-- Please Select --</option>

                                <option value="Under 1 year">Under 1 year</option>
                                       <option value="1-3 years">1-3 years</option>
                                       <option value="3-5 years">3-5 years</option>
                                       <option value="5-10 years">5-10 years</option>
                                       <option value="Over 10 years">Over 10 years</option>

                        </select>
                 </div>
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
                       <label>Suburb</label>
                        <input type="text" name="suburb" value="" />
                 </div>
              <div class="form1">
                       <label>Education Provider Name</label>
            <input class="auto" type="text" id="edu" name="edu" value="" />
                        <input type="hidden" name="edu-id" id="edu-id" value="" />
               
                 </div>
                 <div class="form1">
                 		
                 </div>
                 
                 <div class="form1">
                 		<button class="orange-button width100">Search Now</button>
                                                <a href="/search-student"><button type="button" class="orange-button width100">Reset Search</button></a>

                 </div>
                 <input type="hidden" name="search-submit" value="TRUE" /> <input type="hidden" name="search-checksum" value="<?php echo $_SESSION['search-checksum']; ?>" /> 
        </form>
        </div>
        <div id="right2">
            
          <?php
		  $sqlnew = $sql." LIMIT 1000";
		  $exec = mysqli_query($dbc, $sqlnew);

		  if(mysqli_num_rows($exec) >= 1){
			  echo "<h4>".mysqli_num_rows($exec)." Students found</h4>";
			  

	$total_pages = mysqli_num_rows($exec);
	$targetpage = "search-student"; 	
	$limit = 10; 								
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
				  $uid = $row['usernum'];
				  $fname = $row['firstname'];
				  $lname = $row['lastname'];
				  $profile = $user->profilepicture($uid);
				  $friend = $Wall->FriendCount($uid);
				  $follower = $Wall->FollowerCount($uid);
				  $country = $row['country'];
				  $course = $row['course'];
				  $country = $user->countrycode($country);
				  $time = $row['time_australia'];
				  $lang = $Wall->langget($uid);
				  $interests = $Wall->interestget($uid);
				  $photos = $Wall->PhotoTotal($uid);
				  if(!empty($row['dob'])){$age = ", ".calcutateAge($row['dob']);}
				  else{$age="";}
				  if(!empty($country)){$countryhtml = "From: ".$country." |";}
				  else{$countryhtml = "";}
				   if(!empty($time)){$timehtml = "Time In Australia: ".$time;}
				  else{$timehtml = "";}
				  
				  $followerstatus = $Wall->FollowerStatus($uid, $uidsession);
					if($followerstatus == "true"){$follow = "<span id='follow_$uid'><b>Following</b></span>";$status="status='following'";}
					else{$follow = "<span id='follow_$uid'  ><b>Follow Me</b></span>"; $status="status='add'";}
				  
				  
				  
				  echo <<<END
				  <div class="containerbox" style="position:relative; height:240px;">
            	<div class="facesboxx">
                    <div class="scholarship"></div>
                    <img width="144" height="151" src="/config/timthumb.php?src=$profile&w=144&h=151&q=90&s=1">
            	</div>
                <div class="infosboxx">
                    <h2>$fname $lname$age</h2>
                    <h6>$education</h6>
                    <p><b>I Speak:</b> $lang</p>
                    <p><b>Major/Course:</b> $course</p>
                    <p><b>Interests:</b> $interests</p>
            	</div>
                <div class="statssboxx">
                    
                    <div class="displblock"><i class="icofollowerss"></i><p>Followers (<span id="followercount_$uid">$follower</span>)</p></div>
                    <div class="displblock"><i class="icofriendss"></i><p>Friends ($friend)</p></div>
                    <div class="displblock"><i class="icofollowerss"></i><p>Photos ($photos)</p></div>
            	</div>
                
                <div class="fullbox">
                    <div class="littletext fleft">$countryhtml $timehtml</div>
                    <div class="fright">
					<button class="followme" userid='$uid' $status style="margin-right:15px;"><i class="followico"></i>
															$follow

					
					</button>
					

					<a href="/profile/$uid"><button class="orange-button">View Profile</button></a></div>
                </div>
                
            </div>
				  
END;
			  }
			  
			  
			  
			  
			  }
			  else{echo "<h4>0 Students found</h4>";}

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
<?php if($uidsession != ""):?>
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
var num = parseInt($('#followercount_'+userid).html());
$('#followercount_'+userid).html(num+1)
$("#follow_"+userid).html("<b>Following</b>").attr('status', 'following');

}
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
</html>