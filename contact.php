<?php
/*
  Copyright © Julian Nicholls 2010-2016, All Rights Reserved.
  Licensed for use on one site: reallybigshoe.co.uk
*/

//---------------------------------------------------------------------------
// Defined Values
//---------------------------------------------------------------------------

    define('DESTINATION', 'julian@reallybigshoe.co.uk');
    define('FROM_FORM',   'info@reallybigshoe.co.uk');
    define('FROM_EMAIL',  'Really Big Shoe Contact Form <' . FROM_FORM . '>');
    define('FROM_HEADER', 'From: ' . FROM_EMAIL . "\n");

    ini_set('SMTP', 'mail.reallybigshoe.co.uk');
    ini_set('sendmail_from', FROM_FORM);

//---------------------------------------------------------------------------

    if( $_SERVER['HTTP_HOST'] == 'localhost:8080' )
    {
        echo '<pre>' . print_r($_POST, TRUE) . '</pre>';
        return;
    }

    $subject = isset($_POST['subject']) ? $_POST['subject'] : '(No Subject)';

    $body .= "Name:          " . $_POST['uname'];
    $body .= "\nEmail Address: " . $_POST['email'];
    $body .= "\n\nSubject:       $subject";
    $body .= "\nMessage\n\n  " . $_POST['message'];

    $body .= "ReCaptcha Response: " . $_POST["g-recaptcha-response"];

// Send it

    if($_POST['uname'] == '' || !mail(DESTINATION, "Really Big Shoe Contact - $subject" , $body, FROM_HEADER))
    {
        if(isset($_GET['a']))   // Ajax request
            echo "FAILED";
        else
        {
            html_header();
            echo '<h1>Error 500</h1><p>There is currently a problem with sending messages.</p>';
            echo '<p>Please try again later.</p>';
            html_footer();
        }
    }
    elseif(isset($_GET['a']))      // Ajax request
        echo "OK";
    else
        header("Location: http://reallybigshoe.co.uk/contact.html");


function html_header()
{
    echo '<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Really Big Shoe: Mail Problem/title>
</head>

<body>
';
}


function html_footer()
{
    echo "\n</body><\n</html>\n";
}
