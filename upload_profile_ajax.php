<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
$uid = $_SESSION['uid'];
$user = new User();
include("config/public.php");
$path = "/var/www/istudent.org/uploads/profile/";
function getExtension($str) 
{

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" && !empty($uid))
		{
			$uid = $_SESSION['uid'];
			$name = $_FILES['profile']['name'];
			$size = $_FILES['profile']['size'];
			
			if(strlen($name))
				{
					 $ext = getExtension($name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(4068*4068))
						{
							$code = rtrim(base64_encode(md5(microtime())),"=");
							$actual_image_name = time().$uid.$code.".".$ext;
							$tmp = $_FILES['profile']['tmp_name'];
							mysqli_query($dbc, "UPDATE students SET profile_picture='$actual_image_name' WHERE dataid='$userid'");
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    
									
								         echo "<img style='border:solid 1px #333;' src='/config/timthumb.php?src=/uploads/profile/$actual_image_name&w=144&h=170&q=90'/>";
								         
									
								}
							else
							 {
								echo "Fail upload folder with read access.";
						     }
						}
						else
						echo "Image file size max 4 MB";					
						}
						else
						echo "Invalid file format.";	
				}
				
			else
				echo "Please select image!";
				
			exit;
		}


?>