
<?php
session_start();
include('connect.php');
if(isset($_SESSION['logged_user'])){
$sql = "select distinct belonging.device_name from belonging, sensor_data
 where belonging.device_id = sensor_data.device_id;";

$result=mysqli_query($con,$sql);

}else{die("illegal operation");}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
 crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title>Sense You've Been Gone</title>
</head>

<body>
<div id="content">
    <h1>Sense You've Been Gone</h1>
    <h2>Sensor Monitor System</h2>
<?php
echo "<h3 align='center'>Welcome! ".$_SESSION['logged_user']."<a href='logout.php'><button>log out</button></a></h3>";
?>

<table id="MainPageSensor" align="center">
  <tbody>
    <tr>
    <td id="Text1">Sensor Name</td>
    <td>
      <form action="sensor_data.php" method="post">
      <select id="SensorName" name="select">
                     <?php
                     while ($row = mysqli_fetch_assoc($result)){
                     echo "<option value='".$row['device_name']."'>".$row['device_name']."</option>";
                     }
                     ?>
      </select>

      <tr>
      <td  align="center" colspan="2"><input type="submit" name="submit" id="BTN1" value="CONFIRM"></td>
      </tr>

     </form>
    </td>
    </tr>
  </tbody>
</table>

<table align="center" id="MainPageAlert">
    <tbody>
    <tr>
        <td id="Text1"><p align="center">Recent Alerts</p></td>
    </tr>
    <tr>
        <td>
            <div id="AlertTable">
            <?php
            include('createTable.php');
            make_table(10000);
            ?>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<!--Below is the alert legend table-->
<div style = "float:left" id="AlertLegend">
<table style="border-style:solid;border-color:black;border-width:thin">
    <tbody>
    <tr>
        <td><img id="ALPicture" src="noun_419317_cc.png"> Open Window</td>
    </tr>
    <tr>
        <td><img id="ALPicture" src="noun_1650242_cc.png">Low Temperature</td>
    </tr>
    <tr>
        <td><img id="ALPicture" src="noun_1617715_cc.png">High Temperature</td>
    </tr>
    <tr>
        <td><img id="ALPicture" src="noun_744833_cc.png">High Humidity</td>
    </tr>
    <tr>
        <td><img id="ALPicture" src="noun_1060134_cc.png">Disconnected Sensor</td>
    </tr>
    <tr>
        <td><img id="ALPicture" src="noun_554938_cc.png">No Alert</td>

    </tr>
    </tbody>
</table>
</div>

<div style = "float:right">
    <a href="account_setting.php" id="AccountSetting">Account Setting</a><br>
    <a href="manage_sensors.php" id="ManageSensors">Manage Your Sensors</a><br>
    <a href="all_alert.php" id="AllAlerts">All Alerts</a>
</div>
</div>
</body>
</html>

</div>
</body>
</html>

<?php mysqli_close($con);?>


