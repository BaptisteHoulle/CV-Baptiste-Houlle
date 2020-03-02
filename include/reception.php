<?php

if (isset($_POST['valider'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $tel = $_POST['tel'];

    if (!empty($email) && !empty($message)) {

        htmlentities($email);
        htmlentities($name);
        strip_tags($name);
        strip_tags($email);
        htmlentities($message);
        strip_tags($message);
        strip_tags($tel);
        htmlentities($email);
   
        $header = 'From: '.$email.'';

        mail('Baptiste.Houlle.BH@gmail.com', $name, $message, $tel, $header); 

    }

    header("Location: ../index.html");
    
}
?>