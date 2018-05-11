
<?php

session_start();
include('connect.php');
if(isset($_SESSION['logged_user'])){

include('createTable.php');

}else{die("illegal operation");}


echo "

<!DOCTYPE html> <html lang='en'> <head>
    <meta charset='UTF-8'>
    <title>Alert Management Page</title>
    <link rel='stylesheet' href='styles.css'> </head> <body> <h1>Sense You've Been Gone</h1> <h2>Sensor Monitor System</h2>
    <h3 align='center'>Welcome! ".$_SESSION['logged_user']."<a href='logout.php'><button>log out</button></a></h3>

<div align='center'>


";
make_table(1000000);

echo "

</div> <div id='AlertLegend'> <table style='border-style:solid;border-color:black;border-width:thin'>
    <tbody>
    <tr>
        <td><img id='ALPicture' src='noun_419317_cc.png'> Open Window</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_1650242_cc.png'>Low Temperature</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_1617715_cc.png'>High Temperature</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_744833_cc.png'>High Humidity</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_1060134_cc.png'>Disconnected Sensor</td>
    </tr>
    <tr>
        <td><img id='ALPicture' src='noun_554938_cc.png'>No Alert</td>
    </tr>
    </tbody> </table> </div> <div style='text-align:center'>
    <form action = 'welcome.php'>
    <p><input type='submit' id='BTN1' value='back'></p>
    </form>
</html>

";
mysqli_close($con);
?>

