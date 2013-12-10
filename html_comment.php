<?php
$com_id=$cdata['commentid'];
$comment=htmlcode($cdata['comment'] );
$time=$cdata['created'];
$datemain = date('d F Y g:ia', $time);
$mtime=date("c", $time);
$com_uid=$cdata['userid'];

$userdata = $user->userdata($com_uid);

?>
<div>
					<div style="float:left;width:30px;margin-right:5px;"><img src="/config/timthumb.php?src=<?php echo $user->profilepicture($com_uid); ?>&w=50&h=50&q=100&s=1" class="ans-image" /></div><div style="float:left;width:450px;"><p><span class="blue"><?php echo $userdata['firstname']." ".$userdata['lastname'];?></span><?php echo $comment; ?><span title="<?php echo $mtime;?>" class="lgray"><?php echo $datemain; ?></span></p></div>
				<div style="clear:both"></div>
                </div>