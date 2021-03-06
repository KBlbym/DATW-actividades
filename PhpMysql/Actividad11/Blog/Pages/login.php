<?php
$titulo = "Pagina de acceso";
include("./shared/_imports.php");

?>

<?php
include("./shared/html/head.php");
?>

<body class="d-flex align-items-center">
    <div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php include("./shared/html/header.php"); ?>
        <form class="form-signin" action="/DATW-DATABASES/PhpMysql/Actividad11/blog/validarUsuario.php" method="post">
            <div class="text-center mb-4">
                <img class="mb-4" src="https://lh3.googleusercontent.com/a-/AOh14GiEWltwRnu5e9ieF7PLcMqM8NeRWL_88Jqb3AWitA=s96-c-rg-br100" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">By Khalifa Boulabyem</h1>
                <?php
                if (isset($_GET['error'])) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $_GET['error'] . "<p>
                    </div>";
                }
                ?>
            </div>

            <div class="form-label-group">

                <input type="email" id="email" name="email" class="form-control" placeholder="Dirección electrónico" required autofocus="">
                <label for="email">Email</label>
            </div>

            <div class="form-label-group">
                <input type="password" id="password" name="pass" class="form-control" placeholder="Contraseña" required="">
                <label for="password">Contraseña</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Recordarme
                </label>
            </div>
            <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
            <p class="text-center p-2">
                <a class="text-info" href="forgotPassword.php">¿Olvidaste tu contraseña?</a>
            </p>
            <p class="divider-text">
                <span class="bg-dark"> O </span>
            </p>
            <h5 class="text-center">¿Aún no tienes cuenta?</h5>
            <a href="./Register.php" class="btn btn-lg btn-outline-info btn-block">Crear cuenta</a>
            <p class="mt-5 mb-3 text-muted text-center">© <?php echo date('yy'); ?></p>
        </form>

    </div>
</body>

</html>