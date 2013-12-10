<?php 
if($cupdatesarray)
{
foreach($cupdatesarray as $data)
{
$c_id=$data['c_id'];
$cuser_id=$data['usernum'];
$maintime=$data['time'];

$cupdatesarray=$Wall->Conversation_List($c_id,$uid);
if($c_id==$top_c_id ) 
{ 
$style='background-color:#a7d8ec';
}
else
{
$style=='';	
}
if($cupdatesarray)
{
foreach($cupdatesarray as $data)
{
$reply=htmlcode_nolink($data['reply']);

       $str_length = strlen($reply);       
       
       if($str_length > 20)
       {
          
           	$reply= substr($reply, 0, 17) . "..." ;
           
       }
$reply_uid=$data['user_id_fk'];
$ctime=$data['time'];
$read_status=$data['read_status'];
$mtime=date("c", $ctime);
if($read_status && $reply_uid!=$uid) 
{ 	
$style='background-color:#dedede';
}
else
{
$style=='';	
}

$profile = $user->profilepicture($cuser_id);
$data = $user->userdata($cuser_id);
?>
<a href="/student/messages/<?php echo $cuser_id; ?>" class='con_name'>
<div id='<?php echo $c_id; ?>' class='conList' style='<?php echo $style; ?>' rel='<?php echo $maintime; ?>'>
<img src='/config/timthumb.php?src=<?php echo $profile; ?>&w=50&h=50&q=100' class='cimg'>

<span class='cname'><?php echo $data['firstname']." ".$data['lastname']; ?></span><br/>

<span id='reply<?php echo $c_id ?>' class='reply'>
	
<?php 

if($reply_uid==$uid) { 
	echo "<img src='/images/send.png'  class='con_send'/>";
	}?>	


<?php echo $reply; ?></span><br/>
<span  class="sttime timeago con_time" title="<?php echo $mtime; ?>" ></span>
</div></a>
<?php 
} } 		  $style=''; } }