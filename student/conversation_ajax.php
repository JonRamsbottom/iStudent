 <?php
include("../config/dbconfig.php");
include("../config/common.php");
include("../config/iStudentUSER.php");
include("../config/Wall.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
$user = new User();
if(isset($_POST['reply']) && isset($_POST['cid']) && !empty($uid))
{
$reply = clean_data($_POST['reply']);
$cid = clean_data($_POST['cid']);
	$data = $Wall->ConversationReply_Insert($reply,$cid,$uid); 
	if($data)
	{
    include_once 'html_ConversationReplycode.php';
}
}
?>
