<?php
include("dbconfig.php");
if(isset($_POST['username']) && !empty($_POST['username'])){
$username=strtolower(mysqli_real_escape_string($dbc, $_POST['username']));
$count = mysqli_num_rows(mysqli_query($dbc, "SELECT usernum FROM `users` WHERE LOWER(username)='$username'"));
$HTML='';
if (!preg_match('/^[a-z0-9.-_]+$/', $username)) {$HTML="error";}
elseif($count > 0){
$HTML='user exists';
}else{
$HTML='';
}
echo $HTML;
}
?>