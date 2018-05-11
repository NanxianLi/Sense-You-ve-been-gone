<?php header("Content-Type: text/html; charset=utf8");
    if(!isset($_POST["submit"])){
        exit("error");
    }
    session_start();
    include('connect.php');
    $name = $_POST['name'];
    $passowrd = $_POST['password'];

    if ($name && $passowrd){$sql = "select * from users where user_name = '".$name."' and passwd='".$passowrd."'";
             $result = mysqli_query($con,$sql);
             $rows=mysqli_num_rows($result);
             if($rows){
                   $row = mysqli_fetch_array($result);
                   $_SESSION['logged_user'] = $row['user_name'];
                   $_SESSION['logged_email'] = $row['email'];
                   $_SESSION['temp_unit'] = 'C';
                   $_SESSION['bar_unit'] = 'inches';

                   header("refresh:0;url=welcome.php");
                   exit;
             }else{
                echo "wrong user name or passwd";
echo"
<script>
setTimeout(function(){window.location.href='login.html';},1000);
</script>";
}
}else{
echo"enter user name and passwd";
echo"
<script>
setTimeout(function(){window.location.href='login.html';},1000);
</script>";
}

mysqli_close($con);
?>
