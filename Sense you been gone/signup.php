<?php
header("Content-Type: text/html; charset=utf8");
if(!isset($_POST['submit'])){
  exit("error");
}
$name=$_POST['name'];
$password=$_POST['password'];
$email=$_POST['email'];

include('connect.php');

if($password==""||$name==""){echo"please enter user name and pass word";
  echo"
    <script>
    setTimeout(function(){window.location.href='signup.html';},1000);
    </script>";
    exit;
}

$q1="select count(*) from users where user_name='".$name."'";
$q2="insert into users values (null,'".$name."','".$password."','".$email."')";
$result1=mysqli_query($con,$q1);
$pass=mysqli_fetch_row($result1);
$pa=$pass[0];

if($pa==1){echo "user already exists";
  echo"
    <script>
    setTimeout(function(){window.location.href='signup.html';},1000);
    </script>";
}
$reslut2=mysqli_query($con,$q2);
if(!$reslut2){
  die('Error: ' . mysqli_connect_error());
  }else{echo "ok";
 echo"
    <script>
    setTimeout(function(){window.location.href='login.html';},1000);
    </script>";


}
mysqli_close($con);
?>
