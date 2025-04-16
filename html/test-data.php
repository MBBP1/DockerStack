<html>
<body>

<?php
  ini_set('display_errors', 1); // set to 0 for production version
  error_reporting(E_ALL); // Report all PHP errors
?>
<br>

<?php echo "temperature: " . $_GET['temperature']; ?>
<br>
<?php

if($_GET['password'] == getenv('API_PASSWORD_2'))
{
      $filename ="data-rpi/temperature_data.txt";
      if (file_exists($filename)) {
      echo "The file $filename exists";
      } else {
      echo "The file $filename does not exist";
      }
      $myFile = fopen("data-rpi/temperature_data.txt", "w") or die("Unable to open
file!");

      $dataTemperature = $_GET['temperature']. ";";
      fwrite($myFile, $dataTemperature); // save data to file
      fclose($myFile); // close file
}
?>

</body>
</html>
