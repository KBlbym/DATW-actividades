<?php
    include("./pages/shared/_imports.php");
    require("./config.php");
    include("./Clases/Validation.php");
    include("./Models/User.php");
    session_start();
    if(isset($_POST["submit"]) && (!empty($_POST["email"]) || !empty($_POST["user"])) ){
    
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $data = Validation::validateUserLoginPDO($conn,$email,$pass);
       
        if($data != null){
            $_SESSION['rol'] = $data->rol;
            $_SESSION['user'] = $data->email;
            $_SESSION['name'] = $data->nombre;
            $_SESSION['id_user'] = $data->id_usuario;
            header("Location: /DATW-DATABASES/PhpMysql/Actividad11/blog/Pages/Posts/Index.php");
        }
        else{
            header("Location: /DATW-DATABASES/PhpMysql/Actividad11/blog/Pages/login.php?error=El email o la contraseña es incorrecto");
            exit();
        }
        $conn = null;
    }
?>