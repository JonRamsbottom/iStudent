<?php
//Wall Class
class Wall{
	public $perpage = 10;
 public function Image_Upload($uid, $image) 
     {
     global $dbc;
     $path="uploads/wall_images/";
     $img_src = $path.$image;
     $ids = 0;
	 $image = clean_data($image);
     $query = mysqli_query($dbc, "INSERT INTO wall_images(`uid`, `path`)values('$uid' ,'$image')");
     $ids = mysqli_insert_id($dbc);
     return $ids;
    }
	
	public function Get_Upload_Image($uid,$image) 
	{	
	 global $dbc;
	 if($image)
	 {
		 $image = clean_data($image);
	 $query = mysqli_query($dbc, "SELECT photoid,path FROM wall_images WHERE path='$image' AND uid='$uid'");
	 }
     $result = mysqli_fetch_array($query);
   	return $result;
    }
	
	public function Get_Upload_Image_ID($imageid) 
	{	
	 global $dbc;
	 if($imageid)
	 {
		 $image = clean_data($image);
	 $query = mysqli_query($dbc, "SELECT photoid,path FROM wall_images WHERE photoid='$imageid'");
	 }
     $result = mysqli_fetch_array($query);
   	return $result;
    }
	
	
	
	
		public function Insert_Update($student, $uid, $update, $uploads, $subject) 
	{
		global $dbc;
	$update= mysqli_real_escape_string($dbc, $update);
    $time = time();
	$uid = clean_data($uid);
	$student = clean_data($student);
	$subject = clean_data($subject);
	$ip= get_client_ip();
 	if(!empty($update) && !empty($uid)){
	$uploads_array=explode(',',$uploads);
	$uploads=implode(',',array_unique($uploads_array));
	
    $query = mysqli_query($dbc, "INSERT INTO `messages` (`message`, `uid_fk`, `studentid`, `ip`, `created`, `uploads`, `subject`) VALUES (N'$update', '$uid', '$student', '$ip', '$time', '$uploads', '$subject')");
	$id = mysqli_insert_id($dbc);
    $newquery = mysqli_query($dbc, "SELECT M.msg_id, M.uid_fk, M.message, M.created, M.uploads, M.subject, U.usernum FROM messages M, users U WHERE M.uid_fk=U.usernum and M.msg_id='$id' LIMIT 1");
    $result = mysqli_fetch_array($newquery);
    return $result;
    }
	else{return false;}
	
	}
	
	
	public function Total_Updates($student,$sort) 
	{
		global $dbc;
$query = mysqli_query($dbc, "SELECT M.msg_id, M.uid_fk, M.message, M.created, U.usernum, M.uploads FROM messages M, users U  WHERE U.active=1 AND M.uid_fk=U.usernum and M.studentid='$student' $morequery order by M.msg_id desc");
return mysqli_num_rows($query);
}
	
	public function Updates($student,$lastid,$sort) 
	{
		global $dbc;
		$page = $this->perpage;
       $morequery="";
       if($lastid)
       {
       $morequery=" and M.msg_id<'".$lastid."' ";
       }
       
 
$data = array();
$uid = $_SESSION['uid'];
if($sort == "my"){
$query = mysqli_query($dbc, "SELECT M.msg_id, M.uid_fk, M.message, M.created, U.usernum, M.uploads, M.subject FROM messages M, users U  WHERE U.active=1 AND M.uid_fk=U.usernum and M.studentid='$student' AND M.uid_fk='$uid' $morequery order by M.msg_id desc LIMIT $page");}
else{
$query = mysqli_query($dbc, "SELECT M.msg_id, M.uid_fk, M.message, M.created, U.usernum, M.uploads, M.subject FROM messages M, users U  WHERE U.active=1 AND M.uid_fk=U.usernum and M.studentid='$student' $morequery order by M.msg_id desc LIMIT $page");}


 
        while($row=mysqli_fetch_array($query))
		{
	    $data[]=$row;
		}
		return $data;
}
	
	public function Like_Check($msg_id,$uid) 
     {
		 global $dbc;
     $msg_id= clean_data($msg_id);
     $uid= clean_data($uid);
     $q=mysqli_query($dbc, "SELECT id FROM thanks WHERE uid='$uid' and msg_id='$msg_id' ");
     if(mysqli_num_rows($q)==0)
     {
     return true;
     }
     else
     {
     return false;
     }
     }
	 
	 public function Like_Count($msg_id) 
     {
		 global $dbc;
     $msg_id= clean_data($msg_id);
     $q=mysqli_query($dbc, "SELECT id FROM thanks WHERE msg_id='$msg_id' ");
	 return mysqli_num_rows($q);
	 }
	 
	 
	 
	 
	  public function Like($msg_id,$uid) 
     {
		 global $dbc;
		 
     $msg_id=clean_data($msg_id);
     $uid=clean_data($uid);
 
    
      $query=mysqli_query($dbc, "INSERT INTO thanks (`msg_id`, `uid`) VALUES('$msg_id', '$uid')");
      $query2=mysqli_query($dbc, "SELECT id FROM thanks WHERE msg_id='$msg_id'");
      $count = mysqli_num_rows($query2);
      return $count;
      
	 }
	 
	 public function AddFriend($studentid,$uid) 
     {
		 global $dbc;
		 
     $studentid=clean_data($studentid);
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT linkid FROM friends WHERE (userid='$studentid' AND friendid='$uid') OR (userid='$uid' AND friendid='$studentid') AND active=1");
	if(mysqli_num_rows($query) >= 1){return "already";}
	else{
      $query=mysqli_query($dbc, "INSERT INTO friends (`userid`, `friendid`, `active`) VALUES ('$uid', '$studentid', 0)");
      return "success";
	}
      
	 }
	 
	 public function FriendStatus($studentid,$uid) 
     {
		 global $dbc;
		 
     $studentid=clean_data($studentid);
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT linkid FROM friends WHERE (friendid='$uid' AND userid='$studentid' AND active=1) OR (userid='$uid' AND friendid='$studentid' AND active=1) ");
		  $query1=mysqli_query($dbc, "SELECT linkid FROM friends WHERE userid='$studentid' AND friendid='$uid' AND active=0");
		   $query2=mysqli_query($dbc, "SELECT linkid FROM friends WHERE friendid='$studentid' AND userid='$uid' AND active=0");
	if(mysqli_num_rows($query) >= 1){return "already";}
	elseif(mysqli_num_rows($query1) >=1){return "requested";}
		elseif(mysqli_num_rows($query2) >=1){return "request";}
	else{
      
      return "none";
	}
      
	 }
	 
	
	 public function FriendRequestCount($uid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT linkid FROM friends WHERE (friendid='$uid') AND active=0");
	return mysqli_num_rows($query);
	
      
	 }
	 
	 public function FriendRequestData($uid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
 $requests = array();
          $query=mysqli_query($dbc, "SELECT userid FROM friends WHERE (friendid='$uid') AND active=0");
	while($row=mysqli_fetch_array($query)){
		$requests[] = $row['userid'];
		
	}
      return $requests;
	 }
	
	
	 public function FriendRequestAccept($uid, $studentid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
	 $studentid=clean_data($studentid);
          mysqli_query($dbc, "UPDATE friends SET active=1 WHERE friendid='$uid' AND userid='$studentid'");
	 }
	
	
	
	
	
	
	 public function FriendCount($uid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT linkid FROM friends WHERE (friendid='$uid' OR userid='$uid') AND active=1");
	return mysqli_num_rows($query);
	
      
	 }
	
	
	public function AddFollower($followingid,$uid) 
     {
		 global $dbc;
		 
     $followingid=clean_data($followingid);
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT id FROM followers WHERE userid='$uid' AND followingid='$followingid'");
		  if(mysqli_num_rows($query) >= 1){return "true";}
		  else{
			  mysqli_query($dbc, "INSERT INTO followers (`userid`, `followingid`) VALUES ('$uid', '$followingid')");
			  return "true";
			  
		  }
      
	 }
	
	public function FollowerStatus($followingid,$uid) 
     {
		 global $dbc;
		 
     $followingid=clean_data($followingid);
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT id FROM followers WHERE userid='$uid' AND followingid='$followingid'");
		  if(mysqli_num_rows($query) >= 1){return "true";}
		  else{
			  return "false";
			  
		  }
      
	 }
	
	
	public function FollowerCount($uid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT id FROM followers WHERE followingid='$uid'");
		  return mysqli_num_rows($query);
      
	 }
	
	public function ViewCount($studentid, $month){
		global $dbc;
		if(!empty($month)){$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE month='$month' AND studentid='$studentid'");}
		else{
			$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE studentid='$studentid'");
			}
		return mysqli_num_rows($exec);
	}
	
	public function GetFriends($studentid){
		global $dbc;
		$friends = array();
		$query=mysqli_query($dbc, "SELECT friendid FROM friends WHERE userid='$studentid' AND active=1");
		while($row=mysqli_fetch_array($query)){
			$friends[] = $row['friendid'];
		}
		$query=mysqli_query($dbc, "SELECT userid FROM friends WHERE friendid='$studentid' AND active=1");
		while($row=mysqli_fetch_array($query)){
			$friends[] = $row['userid'];
		}
		return $friends;
	}
	
	public function ThanksCount($uid) 
     {
		 global $dbc;
		 
     $uid=clean_data($uid);
 
          $query=mysqli_query($dbc, "SELECT messages.msg_id FROM thanks LEFT JOIN messages ON thanks.msg_id=messages.msg_id WHERE messages.uid_fk='$uid'");
		  return mysqli_num_rows($query);
      
	 }
	
	public function ViewCountCountry($studentid, $country, $month){
		global $dbc;
		if(!empty($month) && !empty($country)){$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE month='$month' AND studentid='$studentid' AND country='$country'");}
		else if(!empty($month) && empty($country)){$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE month='$month' AND studentid='$studentid' AND country!='AU' AND country!='US' AND country!='CN' AND country!='JP'");}
		else if(!empty($country)){$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE studentid='$studentid' AND country='$country'");}
		else{
			$exec = mysqli_query($dbc, "SELECT * FROM viewtracker WHERE studentid='$studentid' AND country!='AU' AND country!='US' AND country!='CN' AND country!='JP'");
			}
		return mysqli_num_rows($exec);
		
		
	}
	
	public function GetFollowers($studentid){
		global $dbc;
		$follow = array();
		$query=mysqli_query($dbc, "SELECT userid FROM followers WHERE followingid='$studentid'");
		while($row=mysqli_fetch_array($query)){
			$follow[] = $row['userid'];
		}
		return $follow;
	}
	
		public function OfferInsert($studentid, $offer, $offertext){
		global $dbc;
		$query=mysqli_query($dbc, "INSERT INTO offers (`offer`, `offertext`, `userid`) VALUES ('$offer', '$offertext', '$studentid')");
		$id = mysqli_insert_id($dbc);
		return mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM offers WHERE offerid='$id' LIMIT 1"));
	}
	
	public function OfferGet($studentid){
		global $dbc;
		return mysqli_query($dbc, "SELECT * FROM offers WHERE userid='$studentid' ORDER BY time DESC");
	}
	public function AlbumCreate($studentid, $albumname){
		global $dbc;
		mysqli_query($dbc, "INSERT INTO albums (`userid`, `albumname`) VALUES ('$studentid', '$albumname')");
		$id = mysqli_insert_id($dbc);
		return mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM albums WHERE albumid='$id'"));
	}
	
	public function AlbumGet($studentid){
		global $dbc;
		return mysqli_query($dbc, "SELECT * FROM albums WHERE userid='$studentid' ORDER BY datecreated DESC");
	}
	public function AlbumGetData($albumid, $studentid){
		global $dbc;
		$query= mysqli_query($dbc, "SELECT * FROM albums WHERE albumid='$albumid' AND userid='$studentid'");
		if(mysqli_num_rows($query) >= 1){return mysqli_fetch_array($query);}
		else{return 0;}
	}
	public function PhotoGet($albumid){
		global $dbc;
		$query= mysqli_query($dbc, "SELECT * FROM photos WHERE albumid='$albumid' ORDER BY timecreated DESC");
		if(mysqli_num_rows($query) >= 1){return $query;}
		else{return "";}
	}
	public function PhotoCount($albumid){
		global $dbc;
		$query= mysqli_query($dbc, "SELECT * FROM photos WHERE albumid='$albumid'");
		return mysqli_num_rows($query);
	}
	public function PhotoAdd($albumid, $filename){
		global $dbc;
		$q = mysqli_query($dbc, "INSERT INTO photos (`albumid`, `filename`) VALUES ('$albumid', '$filename')");
		$id = mysqli_insert_id($q);
		return $id;
	}
	public function PhotoTotal($studentid){
		global $dbc;
		$q = mysqli_query($dbc, "SELECT photos.* FROM photos LEFT JOIN albums ON photos.albumid=albums.albumid WHERE albums.userid='$studentid'");
		return mysqli_num_rows($q);
	}
	
	public function langget($studentid){
		global $dbc;
		$val = array();
		$q = mysqli_query($dbc, "SELECT name FROM language WHERE userid='$studentid' ORDER BY name");
		while($row=mysqli_fetch_array($q)){$val[]=$row['name'];}
		return implode(", ", $val);

	}
	
	public function langadd($studentid, $lang){
		global $dbc;
		$q = mysqli_query($dbc, "SELECT id FROM language WHERE userid='$studentid' AND name='$lang'");
		if(mysqli_num_rows($q) == 0){
		mysqli_query($dbc, "INSERT INTO language (`userid`, `name`) VALUES ('$studentid', '$lang')");}
		return self::langget($studentid);
	}
	
	public function interestget($studentid){
		global $dbc;
		$val = array();
		$q = mysqli_query($dbc, "SELECT name FROM interests WHERE userid='$studentid' ORDER BY name");
		while($row=mysqli_fetch_array($q)){$val[]=$row['name'];}
		return implode(", ", $val);

	}
	
	public function interestadd($studentid, $name){
		global $dbc;
		$q = mysqli_query($dbc, "SELECT id FROM interests WHERE userid='$studentid' AND name='$name'");
		if(mysqli_num_rows($q) == 0){
		mysqli_query($dbc, "INSERT INTO interests (`userid`, `name`) VALUES ('$studentid', '$name')");}
		return self::interestget($studentid);
	}
	
	
		public function Insert_Comment($uid,$msg_id,$comment) 
	{
		global $dbc;
    $time=time();
    $query = mysqli_query($dbc, "SELECT comment FROM `comments` WHERE userid='$uid' and msgid='$msg_id' ORDER BY commentid DESC LIMIT 1 ");
    $result = mysqli_fetch_array($query);
		if ($comment!=$result['comment']) {
            $query = mysqli_query($dbc, "INSERT INTO `comments` (comment, userid, msgid, created) VALUES (N'$comment', '$uid','$msg_id', '$time')");
            $id = mysqli_insert_id($dbc);
			$newquery = mysqli_query($dbc, "SELECT * FROM comments WHERE commentid='$id' LIMIT 1");
            $result = mysqli_fetch_array($newquery);
         
		   return $result;
        } 
		else
		{
		return false;
		}
       
    }
	
	
	public function Getcomments($msg_id) 
	{
		global $dbc;
		$data = array();
    $query = mysqli_query($dbc, "SELECT * FROM comments WHERE msgid='$msg_id'");
     while($row=mysqli_fetch_array($query)){
	    $data[]=$row;
	 }
	 return $data;
    }
	
	public function commentcount($msg_id) 
	{
		global $dbc;
		
    $query = mysqli_query($dbc, "SELECT commentid FROM comments WHERE msgid='$msg_id'");
     
	 return mysqli_num_rows($query);
    }
	
	
		public function Conversation_Insert($user_one, $user_two) 
	{
		global $dbc;
	      	$user_one = clean_data($user_one);
			$user_two = clean_data($user_two);
		    if($user_one!=$user_two)
		    {
		    $q = mysqli_query($dbc, "SELECT c_id FROM conversation WHERE (user_one='$user_one' and user_two='$user_two') or (user_one='$user_two' and user_two='$user_one') ");
			$time=  time();
		 	 if(mysqli_num_rows($q)==0)  
		     { 
			 mysqli_query($dbc, "INSERT INTO conversation (user_one,user_two,time) VALUES ('$user_one','$user_two','$time')");
			return mysqli_insert_id($dbc);
	        }
			else
			{
	        $v = mysqli_fetch_array($q);
		    return  $v['c_id'];
	        
	      }
	    }
	}
	
	
		public function Conversation_Single($user_one,$conversation_uid) 
	{
		global $dbc;
	    $user_one= clean_data($user_one);

		$query = mysqli_query($dbc, "SELECT u.usernum,c.c_id,c.time
		FROM conversation c, users u
		WHERE CASE 
		WHEN c.user_one = '$user_one'
		THEN c.user_two = u.usernum
		WHEN c.user_two = '$user_one'
		THEN c.user_one= u.usernum
		END 
		AND (
		c.user_one ='$user_one'
		OR c.user_two ='$user_one'
		) AND u.usernum='$conversation_uid' ");

		    	while($row=mysqli_fetch_array($query))
		        {
			    $data[]=$row;
			   
			    }
		        if(!empty($data))
				{
		        return $data;
		        }

	}
	
	public function Conversation_List($c_id,$uid) 
	{
		global $dbc;
	     $user_one = clean_data($uid);
	     $c_id = clean_data($c_id);

		 $query = mysqli_query($dbc, "SELECT R.cr_id,R.time,R.reply,R.user_id_fk,R.read_status FROM conversation_reply R WHERE R.c_id_fk='$c_id' ORDER BY R.cr_id DESC LIMIT 1");
			    while($row = mysqli_fetch_array($query))
			    {
			    $data[] = $row;
			    }
		        if(!empty($data))
				{
		        return $data;
		        }

	}
	
	public function Conversation($user_one,$last_time,$conversation_uid) 
	{
		global $dbc;
	       $morequery="";
	       if($last_time)
	       {
	       $morequery=" and c.time<'".$last_time."' ";
	       }
	
	    $user_one = clean_data($user_one);
	
		$query=mysqli_query($dbc, "SELECT u.usernum,c.c_id,c.time
		FROM conversation c, users u
		WHERE CASE 
		WHEN c.user_one = '$user_one'
		THEN c.user_two = u.usernum
		WHEN c.user_two = '$user_one'
		THEN c.user_one= u.usernum
		END 
		AND (
		c.user_one ='$user_one'
		OR c.user_two ='$user_one'
		) AND u.usernum<>'$conversation_uid'
		$morequery ORDER BY c.time DESC Limit 10");

		    	while($row=mysqli_fetch_array($query))
		        {
			    $data[]=$row;
			    }
		        if(!empty($data))
				{
		        return $data;
		        }

	}
	
	public function Conversation_Updates($c_id,$uid,$last,$more,$conversation_uid) 
	{
		global $dbc;
		$c_id = clean_data($c_id);
	
		$query = mysqli_query($dbc, "SELECT R.cr_id FROM users U, conversation_reply R WHERE R.user_id_fk=U.usernum and R.c_id_fk='$c_id'");
		$g = mysqli_num_rows($query);
	   

        	$second_count=$g-20;
			 $squery='';
			
			  if($second_count && $g>20)
			  {
			  $x_count=$second_count.',';
			  }
			
				/* More Records*/
			       $morequery="";
				    if($more == "Y"){$morequery=" and R.cr_id>'".$last."' ";
			       $x_count='';}
			       elseif($last)
			       {
			       $morequery=" and R.cr_id<'".$last."' ";
			       $x_count='';
			       }
				  
      
		   
		$q= mysqli_query($dbc, "SELECT R.cr_id,R.time,R.reply,R.user_id_fk FROM conversation_reply R WHERE R.c_id_fk='$c_id' ORDER BY R.cr_id DESC LIMIT 1");
		$k=mysqli_fetch_array($q);
		$o_uid=$k['user_id_fk'];
		$r=mysqli_fetch_array($query);
		
		if($conversation_uid)
		{
			
		if($o_uid!=$uid)
		{
		mysqli_query($dbc, "UPDATE conversation_reply SET read_status='0' WHERE c_id_fk='$c_id' ORDER BY cr_id DESC LIMIT 1");	
	    }
	
	    }
	
	  

		 $query= mysqli_query($dbc, "SELECT R.cr_id,R.time,R.reply,U.usernum FROM users U, conversation_reply R WHERE R.user_id_fk=U.usernum and R.c_id_fk='$c_id' $morequery ORDER BY R.cr_id ASC LIMIT $x_count 20");
	
		     	while($row=mysqli_fetch_array($query))
		        {
		
			    $data[]=$row;
			    }
		        if(!empty($data))
				{
		          return $data;
		        }

	}
	
	public function ConversationReply_Insert($reply, $cid, $uid) 
	{
		global $dbc;
		$uid = clean_data($uid);
		$time = time();
	
    mysqli_query($dbc, "INSERT INTO conversation_reply (user_id_fk,reply,time,c_id_fk) VALUES ('$uid','$reply','$time','$cid')");
	mysqli_query($dbc, "UPDATE conversation SET time='$time' WHERE c_id='$cid'");

	$q = mysqli_query($dbc, "SELECT if(user_one = '$uid',user_two,user_one) AS uid FROM conversation where c_id = '$cid'");

	$v = mysqli_fetch_array($q);
	$o_uid = $v['uid'];
	if($o_uid!=$uid)
	{	
	
    $g = mysqli_query($dbc, "SELECT read_status FROM conversation_reply WHERE c_id_fk='$cid' and user_id_fk='$uid' ORDER BY cr_id DESC LIMIT 1,1");
    $h = mysqli_fetch_array($g);
    }

	$q = mysqli_query($dbc, "SELECT R.cr_id,R.time,R.reply,U.usernum FROM users U, conversation_reply R WHERE R.user_id_fk=U.usernum and R.c_id_fk='$cid' ORDER BY R.cr_id DESC");
	$v = mysqli_fetch_array($q);
	return $v;

	

	}
	
	}
	