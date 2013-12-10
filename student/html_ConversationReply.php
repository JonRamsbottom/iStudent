<?php
if($last==''){$last=0;}
if(!isset($more)){$more="";}
$Conversation_Updates = $Wall->Conversation_Updates($top_c_id,$uid,$last,$more,$conversation_uid);
if($Conversation_Updates)
{
foreach($Conversation_Updates as $data)
{
include 'html_ConversationReplycode.php';
} }	
?>

