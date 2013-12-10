<?php
$uid = $_SESSION['uid'];
$msg_id=$data['msg_id'];
$orimessage=$data['message'];
$message=htmlcode($orimessage);
//$message = $orimessage;
$time=$data['created'];
$datemain = date('d F Y g:ia', $time);
$mtime = date("c", $time);
$uploads=$data['uploads'];
$msg_uid=$data['uid_fk'];
$subject = $data['subject'];
//$Wall = new Wall();
$profile = $user->profilepicture($msg_uid);
$userdata = $user->userdata($msg_uid);

$thanks=$Wall->Like_Check($msg_id,$uid);
$thankscount=$Wall->Like_Count($msg_id);

if($thanks)
{
	$thanks_status='Say Thanks';
	$thanked = "false";

}
else
{
	$thanks_status='You Said Thanks';
	$thanked = "true";

}
?>

	<div class="post main border" style="height:auto";>
				<img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=50&h=50&q=100&s=1" class="post-image" />
				<h3 class="blue"><a href="/profile/<?php echo $msg_uid;?>" class="blue"><?php echo $userdata['firstname']." ".$userdata['lastname']; ?></a><span title="<?php echo $mtime;?>" class="lgray"><?php echo $datemain; ?></span></h3>
				<p><b><?php echo $subject; ?></b><br /><?php if(strlen($message) >= 350 && $full != "full"){
				    $message = substr($message, 0, strrpos(substr($message, 0, 350), ' '))."<a href='/post/$msg_uid/$msg_id' class='blue'> (more...)</a>";
                    echo nl2br($message);
					
					}
				else{echo nl2br($message);} ?> 
				
                
             
                
                </p><?php
if($uploads)
{
echo '<div class="img_container slider-wrapper main"><div class="slider" id="slider'.$msg_id.'">';
$s = explode(",", $uploads);
$i=1;
$f=count($s);
foreach($s as $a)
{
$newdata=$Wall->Get_Upload_Image_ID($a);
if($newdata)
{
	$path = $newdata['path'];
$final_image=$base_url."/config/timthumb.php?src=/uploads/wall_images/$path&w=565&h=266&q=90&zc=2";
echo '<div id="slide'.$i.'" class="slide"><img src="'.$final_image.'" width="565" height="266" class="imgpreview"  id="'.$msg_id.'" rel="'.$msg_id.'"/></div>';
}
$i=$i+1;
}
echo '</div><div class="slider-direction-nav" id="slider_direction_'.$msg_id.'"></div><div class="slider-control-nav" id="slider_control_'.$msg_id.'"></div></div>';
if($f>2)
{
echo '<script> $("#slider'.$msg_id.'").leanSlider({directionNav: "#slider_direction_'.$msg_id.'",controlNav:"#slider_control_'.$msg_id.'"}); </script>';
}

}
?>
				<div class="main" >	
					<div style="float:left;font-size:10px;"><span id="saythanks<?php echo $msg_id; ?>" thanked="<?php echo $thanked; ?>" class="saythanks" msg_id="<?php echo $msg_id; ?>" style="cursor:pointer"> <?php echo $thanks_status; ?> (</span> <span class="thank_count" id="saythankscount<?php echo $msg_id; ?>"><?php echo $thankscount;?></span>)</div> <div style="float:left;font-size:10px;margin-left:5px;margin-right:5px;">  ·  </div> <div style="float:left;font-size:10px;"><span id="<?php echo $msg_id; ?>" class="commentopen"  style="cursor:pointer"> Comment (</span> <span class="comment_count" id="commentcount<?php echo $msg_id; ?>"><?php echo $Wall->commentcount($msg_id);?></span>)</div>
								<div style="float:right" class="fb-share-button" data-href="http://istudent.blakebytes.com.au/post/<?php echo $msg_uid."/".$msg_id;?>" data-type="button_count"></div>

				</div>	
				
			</div><!-- main post box end -->
			
			<div style="margin-left:-25px; width:520px; display:none;" id="commentbox<?php echo $msg_id; ?>" class="post-ans border">
				<div id="tab-arrow-2"><span></span></div>
                <div id="commentcontain<?php echo $msg_id; ?>">
                
				<?php 
				$comments = $Wall->Getcomments($msg_id);
				foreach($comments as $cdata)
{
include('/var/www/istudent.org/html_comment.php');
}?>
                </div>
                <?php if(!empty($_SESSION['uid'])): ?>
				<div>
					<img src="/config/timthumb.php?src=<?php echo $user->profilepicture($uid); ?>&w=50&h=50&q=100&s=1" id="user-ans-image" class="ans-image" /><span id="tab-arrow-6"></span><form><textarea class="input-border gray" id="commenttextarea<?php echo $msg_id; ?>" placeholder="Add a comment"></textarea><button id="<?php echo $msg_id; ?>" class="comment_save small-button orange-button">Post Comment</button></form>
				</div>
                <?php endif; ?>
                
                </div>
			
