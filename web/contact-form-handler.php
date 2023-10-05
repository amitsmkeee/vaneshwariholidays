<?php
   use PHPMailer\PHPMailer\PHPMailer;
   require '../vendor/autoload.php';
   session_start();
   if(isset($_POST['submit'])) {
    $errors = '';
    if(empty($_POST['name'])  ||
       empty($_POST['email']) ||
       empty($_POST['message']) ||
       strcmp($_POST['captcha_code'] ,$_SESSION['captcha_code']) != 0)
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
        $body = "Name: $name\nEmail: $email_address\nBody:$message";
        sendEmail($email_address, $name, $body);
    } else {
            echo $errors;
    }
   } else if(isset($_POST['travel-search'])) {
        // print_r($_POST);
        // die;
         $errors = '';
        if(empty($_POST['name'])  ||
        empty($_POST['email']) ||
        empty($_POST['destination']) ||
        empty($_POST['noOfPeople']) ||
        empty($_POST['from']) ||
        empty($_POST['to']) ||
        strcmp($_POST['captcha_code'] ,$_SESSION['captcha_code']) != 0)
        {
            $errors .= "\n Error: all fields are required";
        }
        $name = $_POST['name'];
        $email_address = $_POST['email'];
        $destination = $_POST['destination'];
        $noOfPeople = $_POST['noOfPeople'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        if (!preg_match(
        "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
        $email_address))
        {
            $errors .= "\n Error: Invalid email address";
        }

        if( empty($errors))
        {
            $body = "Name: $name\nEmail: $email_address\nBody:$destination \n no Of People:$noOfPeople \nFrom:$from\nTo:$to";
            sendEmail($email_address, $name, $body);
        } else {
                echo $errors;
        }
   } else {
        echo "Error: all fields are required";
   }

    

    function sendEmail($email_address, $name, $body){
        $myemail = 'info@vaneshwariholidays.com';//<-----Put Your email address here.
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
        $mail->addAddress($myemail, 'VaneshwariHolidays');
        $mail->Subject = 'Received a contact information from' ;
        $mail->Body = $body;
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo "succesfully sent mail";       
            header("Location: index.html");
        }
    }
?>