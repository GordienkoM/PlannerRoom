<?php
    namespace App\Core;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    abstract class Mailer
    {
        public static function mailTest($recipientMail, $recipientName , $subject, $message)
        {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Username   = 'c6671327d9a600';                       //SMTP username
                $mail->Password   = '58a078eb9cbf14';                       //SMTP password

                //Recipients
                $mail->setFrom('from@example.com', 'Planner Room');
                $mail->addAddress($recipientMail, $recipientName );                      //recipient email
               
                //Content
                $mail->isHTML(true);                                        //Set email format to HTML
                $mail->Subject = $subject;                                  //Subject
                $mail->Body    = $message;                                  // HTML message
                $mail->AltBody = $message;                                  // message without HTML

                $mail->send();
                return 'Message has been sent';
            } catch (Exception $e) {
                return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }