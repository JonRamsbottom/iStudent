 <?php
 session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$Wall = new Wall();
if(isset($_POST['lastid']) && isset($_POST['profile_id']))
{
$lastid= clean_data($_POST['lastid']);
$studentid=clean_data($_POST['profile_id']);
$sort=clean_data($_POST['sort']);

include('wall_load.php');
}
?>
