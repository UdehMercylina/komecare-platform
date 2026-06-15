<?php

    include('../inc/config.php');
    include('inc/session.php');


    $id = $_SESSION['onboardee'];
    //set login time
    
    $stmt = "UPDATE users set date_view=NOW() WHERE id='".$id."'";
    mysqli_query($conne, $stmt);
    $_SESSION['onboardee'] = $id;

    session_destroy();



    header('location: ../');

?>