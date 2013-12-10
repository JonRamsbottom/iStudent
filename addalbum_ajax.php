<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['album']) && !empty($_POST['album']) && !empty($uid)){
	$data = $Wall->AlbumCreate(clean_data($uid), clean_data($_POST['album']));
	$id = $data['albumid'];
	$name = $data['albumname'];
	echo <<<END
	<a href="/student/albums/$id" class="cool-border">
<img src="/images/default-album.png">
				<span>$name</span><span class="lgray">0 photos</span>
				</a>
END;
}
?>