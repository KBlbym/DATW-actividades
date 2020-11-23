<?php
include("../../../pages/shared/_imports.php");
include('../../../session.php');
if (!$isSignedIn) {
    header("Location: ../../../Pages/login.php");
    exit();
}
require("../../../config.php");
include '../../../Models/User.php';
include '../../../Clases/functions.php';
$titulo = "Datos personales";


$user = User::GetUserById($conn, $_SESSION['id_user']);
if (isset($_POST['submit'])) {
    $isUserDeleted = User::Delete($conn,$_SESSION['id_user']);
    if($isUserDeleted){
        header('Location: ../../../pages/logout.php');
    }
}
?>
<?php include("../../Shared/head.php"); ?>

<body>
    <?php include("../../Shared/header.php"); ?>

    <div class="row">
        <?php include("../../Shared/aside_nav.php"); ?>
        <div class="col-md-9">


            <h4><?php echo $titulo ?></h4>

            <div class="row">
                <div class="col-md-6">
                    <p>Su cuenta contiene datos personales que nos ha proporcionado.
                        Esta página le permite eliminar esos datos.
                    <p>
                        <strong>Eliminar estos datos se eliminará permanentemente su cuenta, y todo lo que tiene relacionado (comentario, entradas ...)
                            y esto no se puede recuperar.</strong>
                    </p>
                    <form id="download-data" method="post" class="form-group">
                        <button class="btn btn-danger" type="submit" name="submit">Borrar cuenta</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
    </div>
    </main>
    </div>
    <?php include("../../Shared/footer.php"); ?>
</body>

</html>