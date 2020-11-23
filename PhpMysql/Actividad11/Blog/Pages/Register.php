<?php
$titulo = "Crear nueva cuenta";
include("./shared/_imports.php");
require("../config.php");
include("../Models/User.php");
$error = "";
$isFormValid = true;
//crear el usuario
if (isset($_POST['submit'])) {
    if (empty($_POST['nombre'])) {
        $error .= "Nombre es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['email'])) {
        $error .= "Email es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['pass'])) {
        $error .= "Password es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['confirmPassword'])) {
        $error .= "Confirmar password es oblegatorio<br>";
        $isFormValid = false;
    }
    if ($isFormValid) {
        $user = new User(null, $_POST['nombre'],null,null, $_POST['email'], $_POST['pass'], "user", true, false);

        //si retorna -1 email existe en la base de datos.
        //Si retorna 1 se han insertado los datos.
        //si Retorna 0 error no controlado
        $registerUser = $user->Add($conn);

        if ($registerUser == 1) {
            header("Location: login.php");
            exit();
        } else if ($registerUser == 0) {
            $error = "habido un error al intentar añadir el usuario";
        } else {
            $error = "El email " . $user->Email . " ya existe!";
        }
    }
    $conn = null;
}
?>
<?php
include("./shared/html/head.php");
?>

<body class="d-flex align-items-center">
    <div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php
        include("./shared/html/header.php");
        ?>
        <form class="form-signin" action="" method="post">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Crear nueva cuenta</h1>
                <div class="text-danger validation-summary-valid" data-valmsg-summary="true">
                    <ul style="border:none;">
                        <li style="display:none"></li>
                    </ul>
                </div>
                <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $error . "<p>
                    </div>";
                }
                ?>
            </div>
            <div class="form-label-group">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre completo" data-val="true" data-val-length="El nombre debe tener como maximo 80 caracteres" data-val-length-max="80" data-val-length-min="3" data-val-required="El nombre es oblegatorio" maxlength="80">
                <label for="nombre">Nombre</label>
                <span class="text-danger field-validation-valid" data-valmsg-for="nombre" data-valmsg-replace="true"></span>
            </div>

            <div class="form-label-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Dirección electrónico" required data-val="true" data-val-email="Introduce un email valido" data-val-required="El email es obligatorio.">
                <label for="email">Email</label>
                <span class="text-danger field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
            </div>

            <div class="form-label-group">
                <input class="form-control" type="password" data-val="true" data-val-length="La contraseña debe estar entre 4 y 32 caracteres" data-val-length-max="32" data-val-length-min="4" data-val-required="La contraseña es obligatorio" id="pass" maxlength="32" name="pass">
                <label for="password">Contraseña</label>
                <span class="text-danger field-validation-valid" data-valmsg-for="password" data-valmsg-replace="true"></span>
            </div>
            <div class="form-label-group">
                <input class="form-control" type="password" data-val="true" data-val-equalto="La contraseñas no coinciden." data-val-equalto-other="pass" id="confirmPassword" name="confirmPassword">
                <label for="confirmPassword">Confirmar contraseña</label>
                <span class="text-danger field-validation-valid" data-valmsg-for="confirmPassword" data-valmsg-replace="true"></span>
            </div>
            <button name="submit" class="btn btn-lg btn-info btn-block" type="submit">Crear cuenta</button>
            <p class="divider-text">
                <span class="bg-dark"> O </span>
            </p>

            <a href="./login.php" class="btn btn-lg btn-outline-primary btn-block">Iniciar sessión</a>
            <p class="mt-5 mb-3 text-muted text-center">© <?php echo date('yy'); ?></p>
        </form>
        <div>
            <?php
            include("./shared/_importScripts.php");
            ?>

</body>

</html>