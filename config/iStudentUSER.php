<?php
session_start();
// iStudent User Class
// Copyright 2013 - Blake Garrett @ Blake Bytes

class User 
{
	public function userlogin($email,$password){
				global $dbc;
$email = clean_data($email);
//mysqli prepared statements (Prevent SQL injection)
	   $stmt = mysqli_stmt_init($dbc);
$stmt->prepare("SELECT usernum,usertype,password,salt FROM users WHERE email = ? AND active=1");
       $stmt->bind_param("s", $email);
	   $stmt->execute();
	   $stmt->bind_result($usernum, $usertype, $passworddb, $salt);
		$stmt->fetch();
	    $stmt->close(); 
		$data = array();
	    $hash = hash('sha256', $salt . $password );	
		if($hash == $passworddb){
			$data[] = $usernum; $data[] = $usertype;
			return $data;}
		else{return false;}


	}
	
	public function userregister($fname, $lname, $email, $password, $gender){
		global $dbc;
		$fname = clean_data($fname);
		$lname = clean_data($lname);
		$email = clean_data($email);
		$gender = clean_data($gender);
		
		if(!empty($fname) && !empty($lname) && !empty($email) && !empty($gender) && !empty($password)){
			$salt = createSalt();
			$hash = hash('sha256', $salt . $password);
			$ip = get_client_ip();
	   $stmt = mysqli_stmt_init($dbc);
			  $stmt->prepare("INSERT INTO students (`firstname`, `lastname`, `gender`) VALUES (?, ?, ?)");
       $stmt->bind_param("sss", $fname, $lname, $gender);
	   $stmt->execute();
	   $dataid = mysqli_insert_id($dbc);	
	   $stmt->close();
		    
	   $stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("INSERT INTO users (`email`, `password`, `salt`, `data_id`, `usertype`, `active`, `registeredip`) VALUES (?, ?, ?, ?, 1, 1, ?)");
       $stmt->bind_param("sssis", $email, $hash, $salt, $dataid, $ip);
	   $stmt->execute();
	   $usernum = mysqli_insert_id($dbc);	
	   $stmt->close();
			return $usernum;
		}
		else{return false;}
		
		
	}
	
	public function sessionadd($uid, $type){
		$_SESSION['uid'] = $uid;
		$_SESSION['type'] = $type;	
	}
	
	public function logoff(){
		  session_start();
		  session_unset();
    	session_destroy();
	}
	
	public function userdata($uid){
		global $dbc;
		$uid = clean_data($uid);
		$exec = mysqli_query($dbc, "SELECT students.*,users.email,users.facebook_id FROM users LEFT JOIN students ON users.data_id=students.dataid WHERE usernum = '$uid'");
		return mysqli_fetch_array($exec);

		}
	public function checkemail($email){
		global $dbc;
		 $stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("SELECT usernum FROM users WHERE email = ?");
       $stmt->bind_param("s", $email);
	   $stmt->execute();
	   $stmt->store_result();
	   $numrows = $stmt->num_rows;
	   $stmt->close();
	   if($numrows >= 1){return true;}
	   else{return false;}
	}
	
	public function profilepicture($uid){
		global $dbc;
		$stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("SELECT students.profile_picture FROM users LEFT JOIN students ON users.data_id=students.dataid WHERE users.usernum = ?");
       $stmt->bind_param("i", $uid);
	   $stmt->execute();
	    $stmt->bind_result($profilepicture);
		$stmt->fetch();
	    $stmt->close();
	   if(!empty($profilepicture)){return "/uploads/profile/$profilepicture";}
	   else{return "/img/default.png";}  
	}
	
	public function uidcheck($uid){
		global $dbc;
		$stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("SELECT active FROM users WHERE usernum = ?");
       $stmt->bind_param("i", $uid);
	   $stmt->execute();
	    $stmt->bind_result($active);
		$stmt->fetch();
	    $stmt->close();
	   if($active == 1){return true;}
	   else{return false;}  
	}
	public function countrycode($code){
		global $dbc;
			$stmt = mysqli_stmt_init($dbc);
			$code = strtoupper($code);
	   $stmt->prepare("SELECT country FROM countries WHERE code=?");
       $stmt->bind_param("s", $code);
	   $stmt->execute();
	    $stmt->bind_result($country);
		$stmt->fetch();
	    $stmt->close();
		return ucwords(strtolower($country));
		
	}
	
	public function eduprovider($id){
		global $dbc;
			$stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("SELECT name FROM educationprovider WHERE id=?");
       $stmt->bind_param("i", $id);
	   $stmt->execute();
	    $stmt->bind_result($name);
		$stmt->fetch();
	    $stmt->close();
		return $name;
		
	}
	
	public function eduprovidertype($id){
		global $dbc;
			$stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("SELECT type FROM educationprovider WHERE id=?");
       $stmt->bind_param("i", $id);
	   $stmt->execute();
	    $stmt->bind_result($type);
		$stmt->fetch();
	    $stmt->close();
		return $type;
		
	}
	
	public function aboutinfoupdate($id, $gender, $dob, $status, $time, $country, $state, $suburb, $street, $unitno, $houseno, $course, $educationprovider, $info, $ielts, $career_current, $career_previous, $career_objectives, $skype, $unitnoover, $housenoover, $streetover, $suburbover, $postcodeover,$countryover){
		global $dbc;
		
			$stmt = mysqli_stmt_init($dbc);
	   $stmt->prepare("UPDATE students SET gender=?, dob=?, status=?, time_australia=?, country=?, state=?, suburb=?,
	   street=?, unitno=?, houseno=?, course=?, educationprovider=?, info=?, ielts=?, career_current=?, career_previous=?,
	   career_objectives=?, skype=?, unitnoover=?, housenoover=?, streetover=?, suburbover=?, postcodeover=?, countryover=? WHERE dataid=?");
       $stmt->bind_param("sssssssssssissssssssssssi", $gender, $dob, $status, $time, $country, $state, $suburb, $street, $unitno, $houseno, $course, $educationprovider, $info, $ielts, $career_current, $career_previous, $career_objectives, $skype, $unitnoover, $housenoover, $streetover, $suburbover, $postcodeover,
	   $countryover, $id);
	   $stmt->execute();
	    //$stmt->bind_result();
		//$stmt->fetch();
	    $stmt->close();
		//return $name;
		
	}
	
	
}