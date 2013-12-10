<?php
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();

if(isset($_POST['offer']) && isset($_POST['offertext']) && isset($_POST['student'])){
	$data = $Wall->OfferInsert(clean_data($_POST['student']), clean_data($_POST['offer']), clean_data($_POST['offertext']));
	$id = $data['offerid'];
	$offer = $data['offer'];
	$offertext = $data['offertext'];
	echo <<<END
	<div id="offer_$id" class="post main border" style="margin-bottom:30px;">
	<span class="yes-2"></span><h2>$offer</h2><div style="clear:both"></div><br />$offertext</div>	
END;
}
?>