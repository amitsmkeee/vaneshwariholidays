<?php
   use PHPMailer\PHPMailer\PHPMailer;
   require '../vendor/autoload.php';

    $errors = '';
    $myemail = 'info@vaneshwariholidays.com';//<-----Put Your email address here.
    if(empty($_POST['name'])  ||
       empty($_POST['email']) ||
       empty($_POST['message']))
    {
        $errors .= "\n Error: all fields are required";
    }
    $name = $_POST['name'];
    $email_address = $_POST['email'];
    $message = $_POST['message'];

    if (!preg_match(
    "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
    $email_address))
    {
        $errors .= "\n Error: Invalid email address";
    }

    if( empty($errors))
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@vaneshwariholidays.com';
        $mail->Password = 'nOReply@987612345';
        $mail->setFrom('noreply@vaneshwariholidays.com', 'Contact Us Form VaneshwariHolidays');
        $mail->addReplyTo($email_address, $name);
        $mail->addAddress('info@vaneshwariholidays.com', 'VaneshwariHolidays');
        $mail->Subject = 'Received a contact information from '.$name;
        $mail->Body = "Name: $name\nEmail: $email_address\nBody:$message";
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo "succesfully sent mail";
            header("Location: index.html");
        }
    } else {
            echo $errors;
    }
?>