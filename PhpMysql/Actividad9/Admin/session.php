<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: /DATW-DATABASES/PhpMysql/Actividad9/admin/login.php");
        die();
     }else{
         $isAdmin = strtolower($_SESSION['rol']) == "admin" ? true : false;
     }
    
?>