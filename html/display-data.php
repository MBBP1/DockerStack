 <?php
ini_set('display_errors', 1); // set to 0 for production version
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Report all PHP errors 
?>

 <?php

$db_servername = getenv("MYSQL_HOST_2");
$db_username = getenv("MYSQL_USER_2");
$db_password = getenv("MYSQL_PASSWORD_2");
$db_name = getenv("MYSQL_DATABASE_2");

// Create connection
$conn = new mysqli($db_servername ,$db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// prepare sql query
$sql = "SELECT id, value, measurement_date FROM temperature ORDER BY id DESC LIMIT 15";
$result_data_temperatures = $conn->query($sql);

// prepare sql query
$sql = "SELECT id, file_name, creation_date FROM photo ORDER BY id DESC LIMIT 15";
$result_data_photos = $conn->query($sql);

// close database connection
$conn->close();

?> 
<!DOCTYPE html>

<html>
<head>
    <title>My Project - RPI, Arduino, Camera, Sensor</title>
    <meta http-equiv="refresh" content="60"> <!-- refresh page automatically refresh a web page in 60 seconds -->
</head>
<style>
table, th, td {
  border:1px solid grey;
  padding: 5px; 
}

th {
	background: #c9cdd4;
}
div {
  float: left;
  padding: 15px; 
}

.div1 {
  background: #e6e8eb;
}

.div2 {
  background: #ccd9ed;
}


</style>

<body>

<h2>My data: Raspberry Pi, Camera, Arduino, temperature sensor</h2>

<p>My description.</p>


<div class="div1">

<table style="">
  <tr>
    <th colspan="3" scope="colgroup">Photos</th>
  </tr>
  <tr>
    <th>Id</th>
	<th>Photo</th>
    <th>Date and time</th>
  </tr>
  
  <?php
  
  $img_target_dir = "data-rpi/images/";
  foreach ($result_data_photos as $row) 
  {
	  echo "<tr>";
	  echo "<td>".$row["id"]."</td>";/**/
	  echo '<td><img src="'.$img_target_dir.$row["file_name"].'" alt="" width="640" height="480"></td>';
	  echo "<td>".$row["creation_date"]."</td>"; 
	  echo "</tr>";
  }
 
	?>    
  
</table>

</div>

<div class="div2">
<table style="">
  <tr>
    <th colspan="3" scope="colgroup">Temperatures</th>
  </tr>
  <tr>
    <th>Id</th>
	<th>Value</th>
    <th>Date and time</th>
  </tr>
  
  <?php
  foreach ($result_data_temperatures as $row) 
  {
	  echo "<tr>";
	  echo "<td>".$row["id"]."</td>";
	  echo "<td>".$row["value"]."</td>";
	  echo "<td>".$row["measurement_date"]."</td>";
	  echo "</tr>";
  }
  ?>    
  

</table>
</div>

</body>
</html>
