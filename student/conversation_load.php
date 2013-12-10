<?php
if($last_time=='')
{
$last_time=0;
}

$cupdatesarray = $Wall->Conversation($uid,$last_time,$conversation_uid);
include('html_conversation_list.php');
?>