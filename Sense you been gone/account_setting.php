
<?php
session_start();
include('connect.php');
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


<div align='center'>
    <form method='POST' action='set_units.php'><table align='center'>
        <tr>
            <td id='Text1'>Current Email Account</td>
            <td colspan='2'>".$_SESSION['logged_email']."</td>
        </tr>
        <tr>
            <td id='Text1'>Temperature Units</td>
            <td><input type='radio' name='temp_unit' value='C'> ^d^c </td>
            <td><input type='radio' name='temp_unit' value='F'> ^d^i </td>
        </tr>
        <tr>
            <td id='Text1'>Pressure Units</td>
            <td><input type='radio' name='bar_unit' value='inches'>inches</td>
            <td><input type='radio' name='bar_unit' value='kPa'>kPa</td>
        </tr>
        <tr>
            <td id='Text1'>Current Name</td>
            <td>".$_SESSION['logged_user']."</td>
        </tr>
        <tr><td colspan='3' align='center'>
        <input type='submit' id='BTN1' name='submit' value='Set Units'>
        </td></tr>
    </table></form>

</div>

<div style='text-align:center'>
    <form action='change_passwd.html'>

    <p><input style='text-align:center' type='submit' id='BTN1' value='Reset Psswd'></p>
    </form>

    <form action='welcome.php'>
    <p><input type='submit' id='BTN1' value='Back'></p>
    </form>

</div>
</body>
</html>
";
}else{die("illegal operation");}
?>
