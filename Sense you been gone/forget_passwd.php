<?php

function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
        }
        return $str;
}

header("Content-Type: text/html; charset=utf8");
    if(!isset($_POST["submit"])){
        exit("error");
    }

session_start();
include('connect.php');
$email = $_POST['email'];

if ($email){$sql = "select * from users where email = '".$email."'";
         $result = mysqli_query($con,$sql);
         $rows=mysqli_num_rows($result);
         if($rows){
               $act_code = randomString($length = 6);
               echo "Please check your email";
               $output = shell_exec("python3 /home/pi/Desktop/emails.py
                         '".$email."' 'Hello, you are reseting password for the Sense You Been Gone system. The activation code is ".$act_code."'");
               $_SESSION['act_code'] = $act_code;
               $_SESSION['email'] = $email;
               header("refresh:0;url=reset_passwd.html");

         }else{
               echo "wrong email";

echo"
<script>
setTimeout(function(){window.location.href='forget_passwd.html';},1000);
</script>";
}
}else{
echo"enter email";
echo"
<script>
setTimeout(function(){window.location.href='forget_passwd.html';},1000);
</script>";
}

mysqli_close($con);
?>
