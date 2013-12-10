  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

 <?php

 session_start();
 include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");

$uid = $_SESSION['uid'];
$Wall = new Wall();
$user = new User();
if(isset($_POST['update']))
{
$update= $_POST['update'];
$uploads= $_POST['uploads'];
$student = $_POST['student'];
$subject = $_POST['subject'];
$data=$Wall->Insert_Update($student, $uid ,$update, $uploads, $subject);
if($data)
{
include_once "html_post.php";
}
}
?>
