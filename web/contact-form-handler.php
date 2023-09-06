<?php
    $errors = '';
    $myemail = 'amitsmkeee@gmail.com';//<-----Put Your email address here.
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
    $to = $myemail;
    $email_subject = "Contact form submission: $name";
    $email_body = "You have received a new message. ".
    " Here are the details:\n Name: $name \n ".
    "Email: $email_address\n Message \n $message";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html\r\n";
    $headers .= 'From: amitsmkeee1@gmail.com' . "\r\n" .
    'Reply-To: reply@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    //redirect to the 'thank you' page
    header('Location: index.html');
    }
?>