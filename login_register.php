<?php

require('Partial/_dbconnect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($emailid,$v_code)
{      
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'noreply.communitytalks@gmail.com';                     //SMTP username
        $mail->Password   = 'AveeJaanaLode';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('noreply.communitytalks@gmail.com', 'CommuNITy-Talks');
        $mail->addAddress($emailid);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'E-Mail Verification from CommuNITy-Talks';
        $mail->Body    = "Hey NITMzian!Thanks For Registration! Here is the link to verify your e-mail address
                            <a href='community-talks.infinityfreeapp.com/verify.php?email=$emailid&v_code=$v_code'>VERIFY EMAIL ADDRESS</a>";
  
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }


}

#for login bro

if(isset($_POST['login']) && $_POST['g-recaptcha-response']!="")
{   
    $secret = "6LeksZkeAAAAAFdFQQIX2o9A67LVqP1Mjs_TYzgg";
    $verifyresponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $rpdata = json_decode($verifyresponse);
    if($rpdata->success){ 
        $safeun = htmlspecialchars($_POST['email_username']);
    $query = "SELECT * FROM `users` WHERE `email`='$safeun' OR `username`='$safeun'";
    $result=mysqli_query($conn,$query);

    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $result_fetch= mysqli_fetch_assoc($result);

            if($result_fetch['is_verified']==1){
            if(password_verify($_POST['password'],$result_fetch['password'])){
                session_start();
                $_SESSION['logged_in']=true;
                $_SESSION['sno']=$result_fetch['sno'];
                $_SESSION['username']=$result_fetch['username'];
               
           /* echo"<script> window.location.href='home.php'</script>"; */
               header("location:home.php");

            }
            else{

                
                echo"<script>
                    alert('Incorrect Password');
                    window.location.href='login.php';
                    </script>
                    ";

            }
          } else{

            echo"<script>
                    alert('E-Mail not verified');
                    window.location.href='login.php';
                    </script>
                    ";
          }
        }
        else
        {
            echo"<script>
            alert('Email or Username Not Registered');
            window.location.href='login.php';
            </script>
            "; 
        }
    }
    else
    {
        echo"<script>
                    alert('Cannot Run Query');
                    window.location.href='login.php';
                    </script>
                    ";

    }

  } else{
            echo"<script>
            alert('Invalid Captcha occured');
            window.location.href='login.php';
            </script>
            ";
  }
} 











#for registration bro
if(isset($_POST['register']) && $_POST['g-recaptcha-response']!="")
{
    $secret = "6LeksZkeAAAAAFdFQQIX2o9A67LVqP1Mjs_TYzgg";
    $verifyresponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $rpdata = json_decode($verifyresponse);
    if($rpdata->success){
        $usernaam = htmlspecialchars($_POST['username']);
        $user_exist_query="SELECT * FROM `users` WHERE `username`='$usernaam' OR `email`='$_POST[email]'";

        $result=mysqli_query($conn,$user_exist_query);
    
        if($result){
    
            if(mysqli_num_rows($result)>0)
            {
                    $result_fetch=mysqli_fetch_assoc($result);
                    if($result_fetch['username']==$_POST['username'])
                    {
                        echo"<script>
                        alert('UserName already taken');
                        window.location.href='signup.php';
                        </script>
                        ";
                    }
                    else
                    {
    
                        echo"<script>
                        alert(' E-MAIL already registered');
                        window.location.href='signup.php';
                        </script>
                        ";
                    }
            }
            else{
                $emailid = $_POST['email'];
                $pass = $_POST['password'];
                $cpass = $_POST['cpassword'];
                $usernaam = htmlspecialchars($_POST['username']);
                if($pass==$cpass){
                 $v_code=bin2hex(random_bytes(16)); 
                 $hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
                $query = "INSERT INTO `users` ( `username`, `email`, `password`, `date`, `verification_code` ,`is_verified`) VALUES ('$usernaam', '$_POST[email]', '$hash', current_timestamp(),'$v_code','0')";
               
               
                if(mysqli_query($conn,$query) && sendMail($_POST['email'],$v_code))
                {
                    echo"<script>
                    alert('Registration Successful. Check your mail/spam folder and verify your email id');
                    window.location.href='login.php';
                    </script>
                    ";
                
                }
                else{
                    echo"<script>
                        alert('SERVER DOWN');
                        window.location.href='signup.php';
                        </script>
                        ";
                }
    
            }
            else{
                echo"<script>
                alert('Passwords Do Not Match');
                window.location.href='signup.php'
                </script>";
            }
    
            }
    
        }
    
    
    
    }
    else{

        echo"<script>
                    alert('Captcha Query error');
                    window.location.href='signup.php';
                    </script>
                    ";
        
    }
   
}

    else
    {
        echo"<script>
                    alert('Invalid Captcha');
                    window.location.href='signup.php';
                    </script>
                    ";
    }


?>