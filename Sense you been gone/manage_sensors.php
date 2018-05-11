<?php
include('change_units.php');
session_start();
if(isset($_SESSION['logged_user'])){

echo "

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Sensor Management Page</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
<h1>Sense You've Been Gone</h1>
<h2>Sensor Monitor System</h2>
<h3 align='center'>Welcome! ".$_SESSION['logged_user']."<a href='logout.php'><button>log out</button></a></h3>
<div align='center'>";

sensor_management();

echo "</div>

<div id='SensorLegend'>
<table style='border-style:solid;border-color:black;border-width:thin'>
    <tbody>
    <tr>
        <td><img id='ALPicture' src='noun_1060134_cc.png'>Disconnected Sensor</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_554938_cc.png'>No Alert</td>
    </tr>
    </tbody>
</table>
</div>

<div style='text-align:center'>
    <form action = 'welcome.php'>
    <p><input type='submit' id='BTN1' value='back'></p>
    </form>

</div>
</body>
</html>
";
}else{die("illegal operation");}

function status_image($alert_in){
  if($alert_in == "disconnected"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_1060134_cc.png'></div>";}
  else{$source_pic = "<div align='center'><img id='ALPicture' src='noun_554938_cc.png'></div>";}
  return $source_pic;
}


function sensor_management(){
  include('connect.php');
  $sql = "select device_name, is_open, alert, temp, hum, bar, Max(time) as time from sensor_data group by device_name;";
  $result=mysqli_query($con,$sql);

  echo "
  <div style='overflow:auto; height:350px;'>
  <table style='border-collapse:collapse;border:solid black' id='AlertTable'>
  <tr style='border:solid black'>
      <td style='border:solid black' align='center'><p><b>Sensor Status</b></p></td>
      <td style='border:solid black' align='center'><p><b>Sensor Name</b></p></td>
      <td style='border:solid black' align='center'><p><b>Contact Status</b></p></td>
      <td style='border:solid black' align='center'><p><b>Temperature(".$_SESSION['temp_unit'].")</b></p></td>
      <td style='border:solid black' align='center'><p><b>Humidity(%)</b></p></td>
      <td style='border:solid black' align='center'><p><b>Pressure(".$_SESSION['bar_unit'].")</b></p></td>
  </tr>

  ";


  while ($row = mysqli_fetch_assoc($result)){
      $window_status = "Closed";
      if($row['is_open']=='true'){$window_status = "Open";}
      $unit_temp = change_temp($row['temp']);
      $unit_bar = change_bar($row['bar']);
      echo "
        <tr style='border:solid black'>
          <td style='border:solid black'><p>".status_image($row['alert'])."</p></td>
          <td style='border:solid black'><p>".$row['device_name']."</p></td>
          <td style='border:solid black'><p>".$window_status."</p></td>
          <td style='border:solid black'><p>".$unit_temp."</p></td>
          <td style='border:solid black'><p>".$row['hum']."</p></td>
          <td style='border:solid black'><p>".$unit_bar."</p></td>
        </tr>
           ";
  }
  mysqli_close($con);
  echo "</table></div>";

}
?>

