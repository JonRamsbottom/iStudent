 <?php
 $perpage = 10;
if($lastid=='')
{
$lastid=0;
}

$updatesarray=$Wall->Updates($studentid,$lastid, $sort);
if($updatesarray)
{
foreach($updatesarray as $data)
{
include("html_post.php");
}}
