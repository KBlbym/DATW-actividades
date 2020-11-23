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
$titulo = "Cambiar Contraseña";
$error = "";
$success = "";
$isFormValid = true;

if (isset($_POST['submitChangePassword'])) {
    if (empty($_POST['oldPassword'])) {
        $error .= "El campo contraseña actual es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['newPassword'])) {
        $error .= "El campo contraseña nueva es obligatorio<br>";
        $isFormValid = false;
    }
    if ($isFormValid) {
        $isEdit = User::UpdatePassword($conn, $_SESSION['id_user'], $_POST['newPassword'],$_POST['oldPassword']);
        //si retorna 1 hay resultados o proceso realizado con exito.
        //Si retorna -1 la contraseña no es correcta.
        //si Retorna 0 error no controlado
        if ($isEdit == 1) {
            $success = "<li>La Contraseña ha sido modificada exitosamente</li>";
        } else if($isEdit == -1){
            $error = "<li>La contraseña actual no es correcta</li>";
        }else{
            $error = "<li>Habido un error, vualva a intentarlo más tarde</li>";
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
            <h4><?php echo $titulo ?></h4>
            <div class="row">
                <div class="col-md-6">
                    <form id="change-password-form" method="post">
                        <div class="text-danger validation-summary-valid" data-valmsg-summary="true">
                            <ul>
                                <li style="display:none"></li>
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </ul>
                        </div>

                        <?php
                        if (!empty($success)) {
                            echo '<div class="text-success validation-summary-valid" data-valmsg-summary="true">
                                <ul>' . $success . '</ul>
                            </div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="oldPassword">Contraseña actual</label>
                            <input class="form-control" type="password" data-val="true" data-val-required="El campo contraseña actual es oblligatorio." id="oldPassword" name="oldPassword" />
                            <span class="text-danger field-validation-valid" data-valmsg-for="oldPassword" data-valmsg-replace="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">Contraseña nueva</label>
                            <input class="form-control" type="password" data-val="true" data-val-length="La contraseña debe estar entre 4 y 32 caracteres." data-val-length-max="32" data-val-length-min="4" data-val-required="El campo contraseña nueva es obligatorio." id="newPassword" maxlength="32" name="newPassword" />
                            <span class="text-danger field-validation-valid" data-valmsg-for="newPassword" data-valmsg-replace="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="confirmNewPassword">Confirmar la contraseña</label>
                            <input class="form-control" type="password" data-val="true" data-val-equalto="La contraseñas no coinciden." data-val-equalto-other="newPassword" id="confirmNewPassword" name="confirmNewPassword" />
                            <span class="text-danger field-validation-valid" data-valmsg-for="confirmNewPassword" data-valmsg-replace="true"></span>
                        </div>
                        <button type="submit" name="submitChangePassword" class="btn btn-primary">Guardar cambios</button>
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