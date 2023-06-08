<?php
//require_once('class.phpmailer.php');
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
                    $mail->IsSMTP();
                    
                    try {
                      $mail->Host       = "smtp.gmail.com"; //isi dengan host email server
                      $mail->SMTPDebug  = 1;     
                      $mail->SMTPSecure = "ssl";    
                      $mail->SMTPAuth   = true; 
					  
					  $mail->IsHTML(true);                               
                      $mail->Port       = 465;   //port yang digunakan 25, 465, 587                 
                      $mail->Username   = "aguspriskasuryana"; // email pengirim
                      $mail->Password   = "bxl181cr92hinduab11021993"; // password email pwngirim        
                      $mail->AddAddress('deprasuckz@gmail.com','deprasuckz'); //email tujuan isi dengan emailmu misal test@test.com
                      $message = "Email ini dikirim dari localhost";
                     
                      $mail->SetFrom('aguspriskasuryana@gmail.com','aguspriskasuryana@gmail.com'); // email pengirim
                      $mail->Subject = 'Kirim Email Dari Localhost dengan PHPMailer';                       
                      $mail->MsgHTML('<p>'.$message);
                      $mail->Send();
                    
                echo "    <div class='success-message'>";
                echo "<p>SUKSES MENGIRIM EMAIL DARI LOCALHOST</p>";
                echo "</div>";    
                } catch (phpmailerException $e) {
                      echo $e->errorMessage(); 
                }
             
    
?>