<?php
$total=$Wall->Total_Updates($studentid,$sort);
$perpage = 10;




if($total>$perpage)
{
$link="/index";
$class='';
if(!empty($_SESSION['uid'])){
$link='#';
$class='morelink';	
}

echo <<<END

<div id="more$msg_id" style="margin-left:25px;" >
<a href="$link" class="$class" id="$msg_id" rel="$studentid"><strong>More Posts >>></strong></a>
<br><br>
</div>

END;

 }


?>
 


  