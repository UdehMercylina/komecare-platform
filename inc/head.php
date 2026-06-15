<!DOCTYPE html>
<html>
    
    <head>
        <title><?php echo ($page_name == 'Home') ? $settings->siteTitle. ' | ' .$settings->siteTagline : $page_name. ' | ' .$settings->siteTitle;  ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/img/favicon.jpg">

        <!-- Bootstrap Css -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-3.3.6/css/bootstrap.min.css">        
        <!-- Bootstrap Select Css -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-select-1.10.0/dist/css/bootstrap-select.min.css">
        <!-- Fonts Css -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/font-awesome-4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/plugins/font-elegant/elegant.css">
        <!-- OwlCarousel2 Slider Css -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/owl.carousel.2/assets/owl.carousel.css">


        <!-- Animate Css -->       
        <link rel="stylesheet" type="text/css" href="assets/css/animate.css">

        <!-- Main Css -->
        <link rel="stylesheet" type="text/css" href="assets/css/theme.css">
        <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
        
    </head>

<?php

require_once(dirname(__FILE__) . "/admin/includes/conn.php");

$conn = $pdo->open();

function substrwords($text, $maxchar, $end='...') {
   if (strlen($text) > $maxchar || $text == '') {
       $words = preg_split('/\s/', $text);      
       $output = '';
       $i      = 0;
       while (1) {
           $length = strlen($output)+strlen($words[$i]);
           if ($length > $maxchar) {
               break;
           } 
           else {
               $output .= " " . $words[$i];
               ++$i;
           }
       }
       $output .= $end;
   } 
   else {
       $output = $text;
   }
   return $output;
}

?>