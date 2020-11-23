<?php
$indexActive ="";
$emailActive ="";
$changepasswordActive ="";
$personalcataActive ="";
$url = explode('/', $_SERVER['PHP_SELF']);
$fileName = strtolower(end($url));
switch($fileName){
    case "index.php":
        $indexActive ="active";
break;
case "email.php":
    $emailActive ="active";
break;
case "changepassword.php":
    $changepasswordActive ="active";
break;
case "personalcata.php":
    $personalcataActive ="active";
break;
}
?>
<div class="col-md-3">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link <?php echo $indexActive; ?>" name="profile" id="profile" href="./Index.php">Perfil</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $emailActive; ?>" name="changeEmail" id="changeEmail" href="./Email.php">Email</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $changepasswordActive; ?>" name="changePassword" id="change-password" href="./ChangePassword.php">Contraseña</a></li>
        <li class="nav-item"><a class="nav-link" name="twoFactor" id="twoFactor" href="./TwoFactorAuthentication.php">Autentificacion dos pasos</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $personalcataActive; ?>" name="personalData" id="personalData" href="./PersonalData.php">Dato Personal</a></li>
    </ul>
</div>