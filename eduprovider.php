<?php
include("config/dbconfig.php");
include("config/common.php");
if (isset($_GET['term'])){
	$term = clean_data($_GET['term']);
	$return = array();
	$exec = mysqli_query($dbc, "SELECT name,id FROM educationprovider WHERE name LIKE '%$term%'");
	while($row=mysqli_fetch_array($exec)){		
		$return[] = array(
        'value'    => $row['id'],
        'label' => $row['name']
    );
		
	}
	
	echo json_encode($return);
	
}
?>