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
$Wall = new Wall();
$user = new User();
if($user->uidcheck($studentid) == false){header("Location: /index");exit;}
hitcounter($studentid, "profile-about");

$profile = $user->profilepicture($studentid);
$data = $user->userdata($studentid);
$age = calcutateAge($data['dob']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Copyright 2013" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<title><?php echo $data['firstname']. " ". $data['lastname']; ?> | About | iStudent</title>
<?php include_once "html_includes/css.php" ?>

<script  src="http://istudent.blakebytes.com.au/testistudent/js/jquery.min.js"></script>




<style>

.middle-content{
width: 610px;
margin-left:25px;}
.form1 label ,
.form12 label ,
.form22 label {
display:block;
width:100%;
margin-bottom:4px;
}

.form1 ,
.form12 ,
.form22 {
margin-bottom:16px;
}

.form1 {
	width:100%;
	display:block;
	float:left;

}

.form12 select, #left2 .form22 select{
	width:104px;
		padding:5px 5px 4px;
}
.form1 select, #left2 .form1 input[type='date']{
	padding:5px 5px 4px;
	width:212px;
}
.form1 input[type='date'],  .form1 input[type='text']{
	padding:5px 5px 4px;
	width:200px;
}
.form1 textarea{width:200px; 	padding:5px 5px 4px;}

</style>
</head>

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
			$friendstatus = $Wall->FriendStatus($studentid, $uid);
			if($friendstatus == "already"){echo "<a href='#' title='Friends' status='already' id='addfriend'>Friends</a>";}
			elseif($friendstatus == "request"){echo "<a href='#' title='Request Sent' status='request' id='addfriend'>Request Sent</a>";}
						elseif($friendstatus == "requested"){echo "<a href='#' title='Wants to be Friends' status='request' id='addfriend'>Requested</a>";}

			else{echo "<a href='#' title='Add Friend' status='add' id='addfriend'>Add Friend</a>";}
			?>
            
            
            </div>
            
            
			<div class="lgray-button big-button">
            <?php
			$followerstatus = $Wall->FollowerStatus($studentid, $uid);
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
					<li class="active"><a href="/about/<?php echo $studentid;?>" id="about">About Me</a></li>
					<li ><a href="/photos/<?php echo $studentid; ?>" id="my-photos">My Photos (<?php echo $Wall->PhotoTotal($studentid); ?>)</a></li>
					<li><a href="/offers/<?php echo $studentid; ?>" id="my-offers">My Offers</a></li>
					<li><a href="/friends/<?php echo $studentid; ?>" id="my-friends">My Friends (<?php echo $Wall->FriendCount($studentid);?>)</a></li>
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
		<div id="content" class="content">
			<div class="item-info"><h1><?php echo $data['firstname'] ." ". $data['lastname']; ?>, <?php echo $age; ?></h1><div class="place-info"><?php if(!empty($data['state'])){echo $data['state'].",";}?> Australia</div>
			</div>
<div style="clear:both;"></div>
		<div class="middle-content">
       <h1>About Me</h1>
       <br /><br /><br />
<form name="about" action="" method="post">

<div style="float:left; width:48%">
<div class="form1">
  <label for="info">Basic Info</label>
  <textarea readonly name="info" id="info" cols="45" rows="5"><?php echo $data['info']; ?></textarea></div>
   <div class="form1">
  <label for="dob">Date of Birth (dd/mm/yyyy)</label>
  <input readonly name="dob" type="text" id="dob" value="<?php echo $dob; ?>" /></div>
  <div class="form1">
  <label for="gender">Gender</label>
  <select name="gender">
  <?php if($data['gender'] == "M"){
		  echo "<option selected='selected' value='M'>Male</option>    <option value='F'>Female</option>";}
		 else if($data['gender'] == "F"){
		  echo "<option selected='selected' value='F'>Female</option>    <option value='M'>Male</option>";}
		 else{echo "<option value='' selected='selected'>-- Select --</option><option value='F'>Female</option>    <option value='M'>Male</option>";}
		 ?>
  

  </select>
  </div> 
    <div class="form1">
  <label for="time">Time in Australia</label>
  <select name="time">
    <?php if($data['time_australia'] != ""){$time=$data['time_australia'];echo "<option selected='selected' value='$time'>$time</option>";}
		 else{echo '<option selected="selected" value=""></option>';}
		 ?>
    <option value="Under 1 year">Under 1 year</option>
                                       <option value="1-3 years">1-3 years</option>
                                       <option value="3-5 years">3-5 years</option>
                                       <option value="5-10 years">5-10 years</option>
              <option value="Over 10 years">Over 10 years</option>

  </select>
  </div> 
<div class="form1">
  <label for="country">Country of Origin</label>
        <select name="country">
          <?php if($data['country'] != ""){$country=$data['country'];
		  $countryname = $user->countrycode($country);
		  echo "<option selected='selected' value='$country'>$countryname</option>";}
		 else{echo '<option selected="selected" value=""></option>';}
		 ?>
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
  <h2 style="margin-bottom:10px;margin-top:10px; font-size:16px;">Career:</h2>

 <div class="form1">
  <label for="current">Current</label>
  <input readonly name="current" type="text" id="current" value="<?php echo $data['career_current']; ?>" /></div> 
   <div class="form1">
  <label for="previous">Previous</label>
  <input readonly name="previous" type="text" id="previous" value="<?php echo $data['career_previous']; ?>" /></div> 
  
  <div class="form1">
  <label for="career">Career Objectives</label>
  <textarea readonly name="career" id="career" cols="45" rows="5"><?php echo $data['career_objectives']; ?></textarea></div>
    <h2 style="margin-bottom:10px;margin-top:20px; font-size:16px;">Education:</h2>

  <div class="form1" style="margin-top:10px;">
   <label for="edu"><strong>Current Education Provider/School</strong></label>
  <input readonly type="text" class="auto" name="edu" id="edu" value="<?php echo $user->eduprovider($data['educationprovider']); ?>"/> <input type="hidden" name="edu-id" id="edu-id" value="<?php echo $data['educationprovider']; ?>" /></div>
  <div class="form1" >
   <label for="course">Current Course/Major</label>
  <input  readonly name="course" type="text" id="course" value="<?php echo $data['course']; ?>" /> </div>
   <div class="form1">
  <label for="ielts">IELTS Status</label>
  <select name="ielts">
  <?php if($data['ielts'] != ""){$ielts=$data['ielts'];
		  echo "<option selected='selected' value='$ielts'>$ielts</option>";}
		 else{echo '<option selected="selected" value=""></option>';}
		 ?>
    <option >I took IELTS already</option>
  <option >I am looking to take IELTS</option>
  <option >I do not know when I will take it</option>

  </select>
  </div> 
</div>
<div style="float:left; width:48%">
<div class="form1">
  <label for="status">My Status</label>
  <textarea readonly name="status" id="status" cols="45" rows="5"><?php echo $data['status']; ?></textarea></div>
  <div class="form1" >
   <label for="skype">Skype ID</label>
  <input readonly name="skype" type="text" id="skype" value="<?php echo $data['skype']; ?>" /></div>
 <div class="form1">

 

<div id="lang" name="lang" style="margin-top:5px;"><strong>Spoken Languages: </strong><?php echo $Wall->langget($studentid); ?></div>
  </div> 
  <div class="form1">

  
<div id="interests" name="interests" style="margin-top:5px;"><strong>Interests: </strong><?php echo $Wall->interestget($studentid); ?></div>
  </div> 
  
  <h2 style="margin-bottom:10px;margin-top:10px; font-size:16px;">Australian Address:</h2>
<div style="clear:both"></div>
<div class="form1" >
   <table width="100%" border="0">
     <tr>
       <td>Unit No</td>
       <td>Street No</td>
       <td>Street Name/Type</td>
     </tr>
     <tr>
       <td><label for="unitno"></label>
         <input readonly name="unitno" type="text" id="unitno" style="width:30px" value="<?php echo $data['unitno']; ?>" /></td>
       <td><label for="streetno"></label>
         <input readonly name="streetno" type="text" id="streetno" style="width:30px" value="<?php echo $data['houseno']; ?>" /></td>
       <td><label for="streetname"></label>
         <input readonly name="streetname" type="text" id="streetname" style="width:140px" value="<?php echo $data['street']; ?>" /></td>
     </tr>
   </table>
   <table width="100%" border="0">
     <tr>
       <td>Suburb</td>
       <td>State</td>
     </tr>
     <tr>
       <td><label for="suburb"></label>
         <input readonly name="suburb" type="text" id="suburb" style="width:150px" value="<?php echo $data['suburb']; ?>" /></td>
       <td>
         <select style="width:100px" name="state">
         <?php if($data['state'] != ""){$state=$data['state'];echo "<option selected='selected' value='$state'>$state</option>";}
		 else{echo '<option selected="selected" value=""></option>';}
		 ?>
         
         <option value="NSW" >NSW</option>
                                                                <option value="QLD">QLD</option>
                                                                                                <option value="ACT">ACT</option>

                                <option value="VIC">VIC</option>
                                <option value="TAS">TAS</option>
                                <option value="NT">NT</option>
                                <option value="WA">WA</option>
                                                                <option value="SA">SA</option>
         </select></td>
     </tr>
   </table>
</div>
 <h2 style="margin-bottom:10px;margin-top:10px; font-size:16px;">Overseas Address:</h2>
<div style="clear:both"></div>
<div class="form1" >
   <table width="100%" border="0">
     <tr>
       <td>Unit No</td>
       <td>Street No</td>
       <td>Street Name/Type</td>
     </tr>
     <tr>
       <td><label for="unitno"></label>
         <input readonly name="unitnoover" type="text" id="unitnoover" style="width:30px" value="<?php echo $data['unitnoover']; ?>" /></td>
       <td><label for="streetno"></label>
         <input readonly name="streetnoover" type="text" id="streetnoover" style="width:30px" value="<?php echo $data['housenoover']; ?>" /></td>
       <td><label for="streetname"></label>
         <input readonly name="streetnameover" type="text" id="streetnameover" style="width:140px" value="<?php echo $data['streetover']; ?>" /></td>
     </tr>
   </table>
   <table width="100%" border="0">
     <tr>
       <td>Suburb/City</td>
       <td>Post/Zip Code</td>
     </tr>
     <tr>
       <td><label for="suburb"></label>
         <input readonly name="suburbover" type="text" id="suburbover" style="width:150px" value="<?php echo $data['suburbover']; ?>" /></td>
       <td><input readonly name="postcodeover" type="text" id="postcodeover" style="width:60px" value="<?php echo $data['postcodeover']; ?>" /></td>
     </tr>
     
   </table>
   <table width="100%" border="0">
     <tr>
       <td>Country</td>
       <td></td>
     </tr>
     <tr>
       <td> <select name="countryover">
       <?php if($data['countryover'] != ""){$countryover=$data['countryover'];
		  $countryname = $user->countrycode($countryover);
		  echo "<option selected='selected' value='$countryover'>$countryname</option>";}
		 else{echo '<option selected="selected" value=""></option>';}
		 ?>
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


                        </select></td>
       <td></td>
     </tr>
     
   </table>
</div>
  </form>
</div>
			
            
            </div>
			
			
		</div><!-- content-->

 <div id="right">
			
			<div id="profile-nav">
				<a href="/search-student" id="nav-search" class="navtip"><b><</b><span>Search Profiles</span></a>
			</div><!-- end profile navigation-->
			
			<div id="massage-box" class="border">
            <?php if(isset($_SESSION['uid'])): ?>
				<span>Send me a message!</span>
				<div class="green-button big-button"><a href="/student/messages/<?php echo $studentid; ?>" title="Message Me" id="message">Message Me</a></div>
                <?php endif; ?>
			</div>
			
			<div id="right-baner">
				<img src="/img/advert_top.png" />
				<div></div>
			</div>
				
		</div><!-- right side-->	</article>
    <?php include_once "html_includes/footer.php" ?></div>
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