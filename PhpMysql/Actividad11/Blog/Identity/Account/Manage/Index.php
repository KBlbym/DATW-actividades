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

if (isset($_POST['submitUser'])) {
    if (empty($_POST['nombre'])) {
        $error .= "El campo Nombre es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['apellidos'])) {
        $error .= "El campo apellidos es obligatorio<br>";
        $isFormValid = false;
    }
    if ($isFormValid) {
        $isEdit = User::Update($conn, $_SESSION['id_user'], $_POST['nombre'], $_POST['apellidos'], $_POST['telefono'],);
        if ($isEdit) {
            $_SESSION['name'] = $_POST['nombre'];
            $success = "<li>Lo datos han sido modificado exitosamente</li>";
        } else {
            $error = "<li>Ha habido un error y no se han modificado los datos</li>";
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
            <h4>Perfil</h4>
            <div class="row">
                <div class="col-md-6">
                    <form id="profile-form" method="post">
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
                                <ul>'.$success.'</ul>
                            </div>';
                            }
                        ?>
                        <div class="form-group">
                            <label for="Username">Email</label>
                            <input class="form-control" disabled type="text" id="email" name="email" value="<?php echo $user->email ?>" />
                        </div>
                        <div class="form-group">
                            <label for="Input_FirstName">Nombre</label>
                            <input class="form-control" type="text" data-val="true" data-val-required="El nombre es olbligatorio." id="nombre" name="nombre" value="<?php echo empty($user->nombre) ? "" : $user->nombre  ?>" />
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input class="form-control" type="text" data-val="true" data-val-required="el campo apellidos es obligatorio." id="apellidos" name="apellidos" value="<?php echo empty($user->apellidos) ? "" : $user->apellidos  ?>" />
                        </div>
                        <div class="form-group">
                            <label for="Input_PhoneNumber">Telefono</label>
                            <input class="form-control" type="tel" data-val="true" data-val-phone="El telefono no es valido." id="telefono" name="telefono" value="<?php echo empty($user->telefono) ? "" : $user->telefono  ?>" />
                            <span class="text-danger field-validation-valid" data-valmsg-for="telefono" data-valmsg-replace="true"></span>
                        </div>
                        <button id="update-profile-button" name="submitUser" type="submit" class="btn btn-primary">Guardar</button>
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