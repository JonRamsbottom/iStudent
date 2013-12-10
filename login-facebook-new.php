<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
session_start();
require 'facebook_sdk/facebook.php';
require 'config/fbconfig.php';
require 'config/dbconfig.php';
require 'config/common.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
			
            ));

// get the user id
$user = $facebook->getUser();
if(!empty($user)) {
    // We have a user ID, so probably a logged in user.
    // If not, we'll get an exception, which we handle below.
    try {

         $firstname = $user_profile['first_name'];
		        $lastname = $user_profile['last_name'];
		$uid = $user;
		$sex = $user_profile['gender'];
		$email = clean_data($user_profile['email']);
$exec = mysqli_query($dbc, "SELECT usernum,facebook_id FROM `users` WHERE `facebook_id`='$uid' OR email='$email'");
$userdata = mysqli_fetch_array($exec);			 
        if(!empty($userdata)){
			if(empty($facebook_id)){mysqli_query($dbc, "UPDATE `users` SET `facebook_id`='$uid' WHERE email='$email'");}
            $_SESSION['uid'] = $userdata['usernum'];

			$_SESSION['type'] = 1;
            header("Location: home");
        }
		else{
			
			
			mysqli_query($dbc, "INSERT INTO `students` (`firstname`, `lastname`, `gender`) VALUES ('$firstname', '$lastname', '$sex')");
	$did = mysqli_insert_id($dbc);
	$ip = get_client_ip();
	mysqli_query($dbc, "INSERT INTO `users` (`email`, `data_id`, `usertype`, `facebook_id`, `active`, `registeredip`) VALUES ('$email', '$did', 1, '$uid', 1, '$ip')");
	$usernum = mysqli_insert_id($dbc);
$_SESSION['uid'] = $usernum;
$_SESSION['type'] = 1;
	header("Location: home");
		
		
    }

    } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
       	$loginUrl = $facebook->getLoginUrl(array( 'scope' => 'email'));
        // redirect if not logged in or not enough permissions
        echo "<script>top.location=\"".$loginUrl."\";</script>";die;
    }

    // Give the user a logout link 
    //echo '<br /><a href="' . $facebook->getLogoutUrl() . '">logout</a>';
} else {

   	$loginUrl = $facebook->getLoginUrl(array( 'scope' => 'email'));
    echo "<script>top.location=\"".$loginUrl."\";</script>";die;

}
?>