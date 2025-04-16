

<?php
 ini_set('display_errors', 1); // set to 0 for production version
 error_reporting(E_ALL);
 
?>

<?php
$target_dir = "data-rpi/images/";
$target_file = $target_dir . basename($_FILES["file-image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if($_POST['password'] == getenv('API_PASSWORD_2')) 
{
	$check = getimagesize($_FILES["file-image"]["tmp_name"]);
	if($check !== false) 
	{
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} 
	else 
	{
		echo "File is not an image.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) 
	{
		echo "Sorry, your file was not uploaded.";
	} 
	else // if ok, try to upload file
	{
		if (move_uploaded_file($_FILES["file-image"]["tmp_name"], $target_file)) 
		{
			echo "The file ". htmlspecialchars( basename( $_FILES["file-image"]["name"])). " has been uploaded.";
		} 
		else 
		{
			echo "Sorry, there was an error uploading your file.";
		}
	}

}

?>
