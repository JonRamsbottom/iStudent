<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
//$uid = $_SESSION['uid'];
$Wall = new Wall();
$path = "/var/www/istudent.org/uploads/wall_images/";
function getExtension($str) 
{

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$uid = $_SESSION['uid'];
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					 $ext = getExtension($name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(2048*2048))
						{
							$actual_image_name = time()."_".$uid.".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    $data = $Wall->Image_Upload($uid,$actual_image_name);
									 $newdata = $Wall->Get_Upload_Image($uid,$actual_image_name);
									 if($newdata)
									{
								         echo '<img src="/uploads/wall_images/'.$actual_image_name.'"  class="preview" id="'.$newdata['photoid'].'"/>';
								         
									}
								}
							else
							 {
								echo "Fail upload folder with read access.";
						     }
						}
						else
						echo "Image file size max 2 MB";					
						}
						else
						echo "Invalid file format.";	
				}
				
			else
				echo "Please select image!";
				
			exit;
		}


?>