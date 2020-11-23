<?php
    session_start();
    $isSignedIn = true;
    $isAdmin = false;
    if(!isset($_SESSION['user'])){
        $isSignedIn = false;
        //header('location: /DATW-DATABASES/PhpMysql/Actividad11/blog/Pages/login.php');
    }else{
        $isAdmin = strtolower($_SESSION['rol']) == "admin" ? true : false;
    }
    
?>