<?php
include('change_units.php');
session_start(); if(isset($_SESSION['logged_user'])){
header("Content-Type: text/html; charset=utf8");
    if(!isset($_POST["submit"])){
        exit("error");
    }
include('connect.php');

$selected_sensor = $_POST['select'];
echo "sensor ".$selected_sensor." selected";

$sql = "select sub.device_name, MAX(time) as time, sub.is_open, sub.temp, sub.hum, sub.bar from (select * from sensor_data where device_name = '".$selected_sensor."') sub;";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);
$unit_temp = change_temp($row['temp']);
$unit_bar = change_bar($row['bar']);

$window_open = "Closed";
if ($row['is_open']=="true"){$window_open = "Opening";}

echo" <!DOCTYPE html> <html lang='en'> <head>
    <title>Welcome</title>
    <script defer src='https://use.fontawesome.com/releases/v5.0.10/js/all.js'
integrity='sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+'
crossorigin='anonymous'></script>
    <script language = 'JavaScript'>

    function temp_plots() {
        document.getElementById('plots').src='temp_plot.png'
        };
    function hum_plots() {
        document.getElementById('plots').src='hum_plot.png'
        };
    function bar_plots() {
        document.getElementById('plots').src='bar_plot.png'
        };


    </script>
    <link rel='stylesheet' href='styles.css'>
    <meta charset='UTF-8'>
    <title>Sense You've Been Gone</title> </head> <body> <div id='content1'>
    <style>
    #temp_plot{
    display = 'hiden'
    }
    </style>
    <h1>Sense You've Been Gone</h1>
    <h2>Sensor Monitor System</h2>
        <h3 align='center'>Welcome! ".$_SESSION['logged_user']."<a href='logout.php'><button>log out</button></a></h3>
        <div align='center'>
    <table border=0 id='SensorPageTable'>
        <tr>
            <td><p align='center'  id='Text1'>Sensor Name</p></td>
            <td><form>".$row['device_name']."</form></td>
        </tr>
        <tr>
            <td><p align='center' id='Text1'>Window State</p></td>
            <td><form>".$window_open."</form></td>
        </tr>
        <tr>
            <td><p align='center' id='Text1'>Temperature(".$_SESSION['temp_unit'].")</p></td>
            <td><form>".$unit_temp."</form></td>
        </tr>
        <tr>
            <td><p align='center' id='Text1'>Humidity(%)</p></td>
            <td><form>".$row['hum']."</form></td>
        </tr>
        <tr>
            <td><p align='center' id='Text1'>Pressure(".$_SESSION['bar_unit'].")</p></td>
            <td><form>".$unit_bar."</form></td>
        </tr>
    </table> </div> </div>
";

$output = shell_exec("python3 /home/pi/Desktop/query.py '".$_SESSION['temp_unit']."' '".$_SESSION['bar_unit']."' '".$selected_sensor."'");


echo "
<p align='center'><img id='plots' src='temp_plot.png'></p>




<p align='center'>
<button onclick='temp_plots()'> Temperature </button>
<button onclick='hum_plots()'> Humidity </button>
<button onclick='bar_plots()'> Pressure </button>
</p>

<form action='welcome.php'>
            <p>
                <input type='submit' id='BTN1' value='back'>
            </p>
</form>

</body>
</html>
";


}else{die("illegal operation");}

mysqli_close($con);
?>

