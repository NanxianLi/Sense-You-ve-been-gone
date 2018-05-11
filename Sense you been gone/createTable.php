<?php

function choose_image($alert_in){
  if ($alert_in == "open window"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_419317_cc.png'></div>";}
  elseif($alert_in == "low temperature"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_1650242_cc.png'></div>";}
  elseif($alert_in == "high temperature"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_1617715_cc.png'></div>";}
  elseif($alert_in == "high humidity"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_744833_cc.png'></div>";}
  elseif($alert_in == "disconnected"){$source_pic = "<div align='center'><img id='ALPicture' src='noun_1060134_cc.png'></div>";}

  return $source_pic;
}

function make_table($time_range){

session_start();
include('connect.php');
if(isset($_SESSION['logged_user'])){
$sql_alert = "select sensor_data.device_name, sensor_data.time, sensor_data.alert from sensor_data, users, belonging
   where sensor_data.device_id = belonging.device_id and belonging.user_id = users.user_id and users.user_name ='".$_SESSION['logged_user']."'
   and sensor_data.time > NOW()-".$time_range." and alert != 'null';";

$alert_result=mysqli_query($con,$sql_alert);

}else{die("illegal operation");}

echo "
<div style='overflow:auto; height:350px;'>
<table style='border-collapse:collapse;border: solid black' id='AlertTable'>
<tr style='border: solid black'>
    <td align='center'><p><b>Sensor Name</b></p></td>
    <td align='center'><p><b>Time</b></p></td>
    <td align='center'><p><b>Alert Type</b></p></td>
</tr>

";

while ($alert_row=mysqli_fetch_array($alert_result)){
  echo "
    <tr>
      <td><p>".$alert_row['device_name']."</p></td>
      <td><p>".$alert_row['time']."</p></td>
      <td>".choose_image($alert_row['alert'])."</td>
    </tr>
        ";
}

echo "
</table></div>
";
}
?>

