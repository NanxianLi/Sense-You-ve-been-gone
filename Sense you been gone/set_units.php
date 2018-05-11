<?php if(!isset($_POST['submit'])){
  exit("error");
}

session_start();
$_SESSION['temp_unit'] = $_POST['temp_unit'];
$_SESSION['bar_unit'] = $_POST['bar_unit'];

echo "success!";
echo"
      <script>
      setTimeout(function(){window.location.href='account_setting.php';},1000);
      </script>";

?>
