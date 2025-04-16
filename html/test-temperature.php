
<?php
 ini_set('display_errors', 1); // set to 0 for production version
 error_reporting(E_ALL); // Report all PHP errors 
 
?>

<?php echo "temperature: " . $_POST['temperature']; ?>


<?php
if($_POST['password'] == getenv('API_PASSWORD_2'))  
{
	$filename ="data-rpi/temperature-data.csv";
	if (file_exists($filename)) {
		echo "The file $filename exists";
	} else {
		echo "The file $filename does not exist";
	}

	$myFile = fopen($filename, "a") or die("Unable to open file!");

	$data = $_POST['temperature']. ",". $_POST['datetime']."\r\n";
	fwrite($myFile, $data); // save data to file 

	fclose($myFile); // close file
}
?>
