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
$titulo = "Administrar su cuenta";
$error = "";
$success = "";
$isFormValid = true;

if (isset($_POST['submitEmail'])) {
    if (empty($_POST['emailNuevo'])) {
        $error .= "El campo nuevo email es obligatorio<br>";
        $isFormValid = false;
    }else{
        //si retorna -1 email existe en la base de datos.
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
        $isEdit = User::UpdateEmail($conn, $_SESSION['id_user'], $_POST['emailNuevo']);
        if ($isEdit == 1) {
            $_SESSION['user'] = $_POST['emailNuevo'];
            $success = "<li>Lo datos han sido modificado exitosamente</li>";
        } else if($isEdit == -1){
            $error = "<li>EL email ". $_POST['emailNuevo']." Ya existe!<li>";
        }
        else{
            $error = "<li> Ha habido un error y no se han modificado los datos<li>";
           
        }
    }
}
$user = User::GetUserById($conn, $_SESSION['id_user']);
?>
<?php include("../../Shared/head.php"); ?>

<body>
    <?php include("../../Shared/header.php"); ?>

                <div class="row">
                <?php include("../../Shared/aside_nav.php"); ?>
                    <div class="col-md-9">
                        <h4>Cambio de email</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <form id="email-form" method="post">
                                    <div class="text-danger validation-summary-valid" data-valmsg-summary="true">
                                        <ul>
                                            <li style="display:none"></li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <div class="input-group">
                                            <input class="form-control" disabled type="text" id="emailCurrent" name="emailCurrent" value="<?php echo $user->email?>" />
                                            <div class="input-group-append">
                                                <span class="input-group-text text-success font-weight-bold">✓</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailNuevo">El nuevo email</label>
                                        <input class="form-control" type="email" data-val="true" data-val-email="El campo nuevo email no es email valido." data-val-required="EL campo nuevo email es obligatorio." id="emailNuevo" name="emailNuevo" value="<?php echo $user->email?>" />
                                        <span class="text-danger field-validation-valid" data-valmsg-for="emailNuevo" data-valmsg-replace="true"></span>
                                    </div>
                                    <button id="change-email-button" type="submit" name="submitEmail" class="btn btn-primary">Cambiar email</button>
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