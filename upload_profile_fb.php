<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
$uid = $_SESSION['uid'];
$user = new User();
include("config/public.php");

if(!empty($uid) && !empty($data['facebook_id'])){
	$fuid = $data['facebook_id'];
	$code = rtrim(base64_encode(md5(microtime())),"=");
			$profile = time().$uid.$code;
	$file = "/var/www/istudent.org/uploads/profile/$profile.jpg";
$profile = "$profile.jpg";


$file = 'http://graph.facebook.com/'.$fuid.'/picture?type=large';
$save_path = "/var/www/istudent.org/uploads/profile/$profile";
$fp = fopen($save_path, 'w');
$ch = curl_init($file);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $fp);
curl_setopt($ch, CURLOPT_FILE, $fp);
$data = curl_exec($ch);
curl_close($ch);
fclose($fp);
mysqli_query($dbc, "UPDATE students SET profile_picture = '$profile' WHERE dataid='$userid'");
echo "<img style='border:solid 1px #333;' src='/config/timthumb.php?src=/uploads/profile/$profile&w=144&h=170&q=90&s=1'/>";

	}



?>