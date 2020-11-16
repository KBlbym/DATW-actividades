<?php
    require("../PDOContext.php");
    include("../clases/MainClass.php");
    include("../Models/User.php");
    include("../shared/_imports.php");
    session_start();
    if(isset($_POST["submit"]) && (!empty($_POST["email"]) || !empty($_POST["user"])) ){

    
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $data = MainClass::validateUserLoginPDO($conn,$email,$pass);
       
        if($data != null){
            $user = new User($data->id_user,$data->nombre,$data->email,$data->pass,$data->rol);
            $_SESSION['rol'] = $user->Rol;
            $_SESSION['user'] = $user->Email;
            $_SESSION['name'] = $user->Name;
            header("Location: ../index.php");
        }
        else{
            header("Location: login.php?error=El email o la contraseña es incorrecto");
            exit();
        }
    }
?>