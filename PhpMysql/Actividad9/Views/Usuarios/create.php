<?php
include('../../admin/session.php');
if(!$isAdmin){
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$titulo = "Bienvenido " . $_SESSION['name'];
require("../../PDOContext.php");
include '../../Models/User.php';
$error ="";
$success="";
$isFormValid = true;
//crear el usuario
if(isset($_POST['submit'])){
    if(empty($_POST['nombre'])){
        $error .= "Nombre es obligatorio<br>";
        $isFormValid = false;
    }
    if(empty($_POST['email'])){
        $error .= "Email es obligatorio<br>";
        $isFormValid = false;
    }
    if(empty($_POST['pass'])){
        $error .= "Password es obligatorio<br>";
        $isFormValid = false;
    }
    if(empty($_POST['rol'])){
        $error .= "ROl es obligatorio<br>";
        $isFormValid = false;
    }
    if($isFormValid){
        $user = new User(null, $_POST['nombre'], $_POST['email'], $_POST['pass'], $_POST['rol']);
        
        //si retorna -1 email existe en la base de datos.
        //Si retorna 1 se han insertado los datos.
        //si Retorna 0 error no controlado
        $createUser = $user->Add($conn);

        if($createUser == 1){
            $error="";
            $success = "¡El Usuario ha sido añadido exitosamente!";
            
        }else if($createUser == 0){
            $success ="";
            $error="habido un error al intentar añadir el usuario";
        }else{
            $success ="";
            $error="El email ". $user->Email ." ya existe!";
        }
    }
    $conn =null;
}

?>

<?php
include('../../shared/html/head.php');
?>

<body class="text-center">
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('../../shared/html/header.php'); ?>
        <form method="post" action="#">
            <h4>Anañir nuevo usuario</h4>
            <hr>
            <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $error . "<p>
                    </div>";
                }
                if (!empty($success)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p class='success'>" . $success . "<p>
                    </div>";
                }
            ?>
            <div class="form-label-group">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre COmpleto" required autofocus="">
                <label for="nombre">Nombre</label>
            </div>

            <div class="form-label-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Dirección electrónico" required autofocus="">
                <label for="email">Email</label>
            </div>

            <div class="form-label-group">
                <input type="password" id="password" name="pass" class="form-control" placeholder="Contraseña" required="">
                <label for="password">Contraseña</label>
            </div>
            <select class="form-control" name="rol" id="rol">
                <option value="admin">Administrador</option>
                <option value="empleado">Empleado</option>
            </select>
            <button type="submit" name="submit" class="btn btn-primary">Añadir</button>
        </form>

        <?php include('../../shared/html/footer.php'); ?>
    </div>
</body>

</html>