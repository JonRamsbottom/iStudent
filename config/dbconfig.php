<?php
DEFINE('DATABASE_USER', 'istudent');
DEFINE('DATABASE_PASSWORD', 'istudent_587_apple');
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', 'istudent');
date_default_timezone_set('Australia/Sydney');
$dbc = @mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD,
 DATABASE_NAME);
if (!$dbc) {
 trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
mysqli_query($dbc, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
mysqli_query($dbc, "SET NAMES 'UTF8'");
?>
