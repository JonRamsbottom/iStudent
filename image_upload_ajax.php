<?php
session_start();
include("config/dbconfig.php");
include("config/common.php");
include("config/iStudentUSER.php");
include("config/Wall.php");
include("config/session.php");
$uid = $_SESSION['uid'];
$Wall = new Wall();
$path = "/var/www/istudent.org/uploads/user-imgs/";
function getExtension($str) 
{

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" && !empty($uid) && !empty($_POST['album']))
		{
			$name = $_FILES['image-upload']['name'];
			$size = $_FILES['image-upload']['size'];
			
			if(strlen($name))
				{
					 $ext = getExtension($name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(4096*4096))
						{
							$code = rtrim(base64_encode(md5(microtime())),"=");
							$actual_image_name = time().$uid.$code.".".$ext;
							$tmp = $_FILES['image-upload']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    $id = $Wall->PhotoAdd(clean_data($_POST['album']),$actual_image_name);
									echo <<<END
									<img src="/config/timthumb.php?src=/uploads/user-imgs/$actual_image_name&w=88&h=81&q=100" id="$id" onClick="mainimg('/config/timthumb.php?src=/uploads/user-imgs/$actual_image_name&w=752&h=514&q=100&zc=2', '/uploads/user-imgs/$actual_image_name')" class="photo_thumb"/>
<script> makemain('/config/timthumb.php?src=/uploads/user-imgs/$actual_image_name&w=752&h=514&q=100&zc=2', '/uploads/user-imgs/$actual_image_name') </script>
END;
								        
								         
									
								}
							else
							 {
								echo "Fail upload folder with read access.";
						     }
						}
						else
						echo "Image file size: max 4 MB";					
						}
						else
						echo "Invalid file format.";	
				}
				
			else
				echo "Please select an image.";
				
			exit;
		}


?>