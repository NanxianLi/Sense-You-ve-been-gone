<?php
header("Content-Type: text/html; charset=utf8");
if(!isset($_POST['submit'])){
  exit("error");
}

session_start();




  $old_password_input=$_POST['old_password'];
  $password=$_POST['password'];
  $password2=$_POST['password2'];

  if($password==""||$old_password_input==""||$password2==""){
    echo"please enter required information";
    echo"
      <script>
      setTimeout(function(){window.location.href='change_passwd.html';},1000);
      </script>";
      exit;
  }
  if($password != $password2 ){
    echo "entered passwords does not match";
    echo"
    <script>
    setTimeout(function(){window.location.href='change_passwd.html';},1000);
    </script>";
        exit;
  }




include('connect.php');
  if ($old_password_input){$sql = "select * from users where user_name = '".$_SESSION['logged_user']."' and passwd = '".$old_password_input."'";
         $result = mysqli_query($con,$sql);
         $rows=mysqli_num_rows($result);
         if($rows){




  $q1="update users set passwd = '".$password."' where user_name = '".$_SESSION['logged_user']."';";

  $result1=mysqli_query($con,$q1);
  echo"
    <script>
    setTimeout(function(){window.location.href='signup.html';},1000);
    </script>";

  session_destroy();
  $home_url = 'login.html';
  header('Location:'.$home_url);


  mysqli_close($con);
}else{
         echo"wrong password";
         echo"
         <script>
         setTimeout(function(){window.location.href='reset_passwd.html';},1000);
         </script>";
         exit;

}



 }else{
         echo"
         <script>
         setTimeout(function(){window.location.href='reset_passwd.html';},1000);
         </script>";
         exit;

}
?>
