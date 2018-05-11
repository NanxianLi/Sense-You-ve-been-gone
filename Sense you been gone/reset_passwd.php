<?php
header("Content-Type: text/html; charset=utf8");
if(!isset($_POST['submit'])){
  exit("error");
}

session_start();

$act_code = $_SESSION['act_code'];
$emails = $_SESSION['email'];


if($act_code!=null && $emails!=null){

  $act_code_input=$_POST['act_code'];
  $password=$_POST['password'];
  $password2=$_POST['password2'];

  include('connect.php');

  if($password==""||$act_code_input==""||$password2==""){
    echo"please enter required information";
    echo"
      <script>
      setTimeout(function(){window.location.href='reset_passwd.html';},1000);
      </script>";
      exit;
  }
  if($password != $password2 ){
    echo "entered passwords does not match";
    echo"
    <script>
    setTimeout(function(){window.location.href='reset_passwd.html';},1000);
    </script>";
        exit;
  }
  if($act_code_input != $act_code ){
    echo "wrong activation code";
    echo"
    <script>
    setTimeout(function(){window.location.href='reset_passwd.html';},1000);
    </script>";
        exit;
  }

  $q1="update users set passwd = '".$password."' where email = '".$emails."';";

 $result1=mysqli_query($con,$q1);
  echo"
    <script>
    setTimeout(function(){window.location.href='signup.html';},1000);
    </script>";

  session_destroy();
  $home_url = 'login.html';
  header('Location:'.$home_url);


  mysqli_close($con);

}else{die("illegal operation");}

?>
