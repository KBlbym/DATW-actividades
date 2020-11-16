<?php
include('../../admin/session.php');
if(!$isAdmin){
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$titulo = "Bienvenido " . $_SESSION['name'];
require("../../PDOContext.php");
include '../../Models/User.php';
$error = "";
//lo primero vamos a rescatar el usuario
//si el get esta informado buscamos el usuario
if (isset($_GET['id'])) {
    $userToEdit = User::GetUserById($conn, $_GET['id']);
    if ($userToEdit == null) {
        header("Location: /DATW-DATABASES/PhpMysql/Actividad9/views/usuarios/");
        exit();
    }
    //guardamos el email del usuario en caso que si modifica el email
    //haremos una llamada a base de datos para volver a verificar si el email existe.
    $currentEmail = $userToEdit->email;
}
//crear el usuario
if (isset($_POST['submit'])) {
    $isDeleted = User::Delete($conn,$_GET['id']);
    if($isDeleted){
        header("Location: /DATW-DATABASES/PhpMysql/Actividad9/views/usuarios/");
    }else{
        $error = "habido un error y no se ha podido eliminar el registro";
    }
    $conn = null;
}

?>

<?php
include('../../shared/html/head.php');
?>

<body>
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('../../shared/html/header.php'); ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $error . "<p>
                    </div>";
                }
            ?>
            <h1>Eliminando <?php echo $userToEdit->nombre; ?></h1>
            <h3>¿Estas seguro que quieres eliminar este usuario?</h3>
            <div>
                <hr>
                <dl class="row">
                    <dt class="col-sm-2">
                        Nombre:
                    </dt>
                    <dd class="col-sm-10">
                        <?php echo $userToEdit->nombre; ?>
                    </dd>
                    <dt class="col-sm-2">
                        Email:
                    </dt>
                    <dd class="col-sm-10">
                        <?php echo $userToEdit->email; ?>
                    </dd>
                    <dt class="col-sm-2">
                        Rol
                    </dt>
                    <dd class="col-sm-10">
                        <?php echo $userToEdit->rol; ?>
                    </dd>
                </dl>

                <form method="post" action="#">
                    <input type="submit" name="submit" value="Eliminar" class="btn btn-danger"> |
                    <a href="/DATW-DATABASES/PhpMysql/Actividad9/views/usuarios/">Volver a usuario</a>
            </div>
        </main>
        <?php include('../../shared/html/footer.php'); ?>
    </div>
</body>

</html>