<?php
$reply=htmlcode($data['reply']);
$cuser_id=$data['usernum'];
$cr_id=$data['cr_id'];
$utime=$data['time'];
$mtime=date("c", $utime);
$profile = $user->profilepicture($cuser_id);
$data = $user->userdata($cuser_id);
?>
<div class="reply_stbody" id="stbody<?php echo $cr_id ?>">
<div class="reply_stimg">
<a href="/profile/<?php echo $cuser_id; ?>"><img src="/config/timthumb.php?src=<?php echo $profile; ?>&w=60&h=60&q=100&s=1" class="big_face" alt=""></a>
</div> 

<div class="reply_sttext">
<b><a href="/profile/<?php echo $cuser_id; ?>" class="pname"><?php echo $data['firstname']." ".$data['lastname']; ?></a></b> 
<?php echo $reply;  ?>
<div class="reply_sttime"> <span class="timeago" title="<?php echo $mtime ?>"></span></div> 
</div> 
</div>

