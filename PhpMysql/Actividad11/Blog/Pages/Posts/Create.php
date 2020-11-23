<?php
include('../../session.php');
if (!$isAdmin) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$titulo = "Bienvenido " . $_SESSION['name'];
require("../../config.php");
include '../../Models/Post.php';
include '../../Clases/functions.php';
$error = "";
$isFormValid = true;

//crear el usuario
if (isset($_POST['submit'])) {
    if (empty($_POST['titulo'])) {
        $error .= "Titulo es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['resumen'])) {
        $error .= "Resumen es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['contenido'])) {
        $error .= "El contenido es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['categoria'])) {
        $error .= "Selecciona una categoria<br>";
        $isFormValid = false;
    }
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error .= "Selectiona una imagen<br>";
        $isFormValid = false;
    }
    else{
        $files_dir = "../../www/img/posts/";
        $fullPath = $files_dir . basename($_FILES["image"]["name"]);
        $imageName = ValidateFile();
        if(!$imageName){
            $error .= "Selectiona una imagen valida ('jpg', 'jpeg','png','gif')<br>";
            $isFormValid = false;
        }
    }
    if ($isFormValid) {
        saveFile($fullPath);
        $post = new Post(null, $_POST['titulo'], $_POST['resumen'], $_POST['contenido'], $_FILES['image']['name'], date("Y-m-d H:i:s"), $_POST['categoria'], $_SESSION['id_user']);
        
        //Si retorna 1 se han insertado los datos.
        //si Retorna 0 error no controlado
        //si retorna -1 entrada existe en la base de datos.
        $addPost = $post->Add($conn);

        if ($addPost == 1) {
            header("location: index.php");
        } else if ($addPost == 0) {
            $error = "habido un error al intentar añadir el la entrada";
            removeFile($fullPath);
            
        } else {
            $success = "";
            $error = "El contenido con el titulo " . $post->Title . " ya existe!";
            removeFile($fullPath);
        }
    }
    $conn = null;
}

?>

<?php
include('../../Pages/shared/html/head.php');
?>

<body class="text-center fluid-container">
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('../../Pages/shared/html/header.php'); ?>
        <div class="row">
            <div class="col-md-12">
            <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $error . "<p>
                    </div>";
                }
            ?>
                <form enctype="multipart/form-data" method="post">

                    <div class="form-group">
                        <label class="control-label" for="titulo">Título</label>
                        <input class="form-control" type="text" data-val="true" data-val-length="El Título No puede contener más de 150 caracteres" data-val-length-max="150" data-val-required="El campo de Título es obligatorio" id="titulo" maxlength="150" name="titulo">
                        <span class="text-danger field-validation-valid" data-valmsg-for="titulo" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="resumen">Discripción</label>
                        <textarea class="form-control" data-val="true" data-val-length="La Discripción No puede contener más de 250 caracteres" data-val-length-max="250" data-val-required="El campo de Discripción es obligatorio" id="resumen" maxlength="250" name="resumen"></textarea>
                        <span class="text-danger field-validation-valid" data-valmsg-for="resumen" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="contenido">Contenido</label>
                        <textarea class="form-control" id="contenido" data-val="true" data-val-required="El campo de Contenido es obligatorio" name="contenido"></textarea>
                        <span class="text-danger field-validation-valid" data-valmsg-for="contenido" data-valmsg-replace="true"></span>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="image">File</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <span class="text-danger field-validation-valid" data-valmsg-for="image" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="categoria">Categoria</label>
                        <select class="form-control" data-val="true" data-val-required="Seleciona una categoria" id="categoria" name="categoria">
                            <option value="1">Deporte</option>
                            <option value="2">Sucesos</option>
                            <option value="3">Historia</option>
                            <option value="4">Teatro</option>
                        </select>
                    </div>
                    <button name="submit" class="btn btn-lg btn-info btn-block" type="submit">Crear</button>
                    
                </form>
            </div>
        </div>
        
    </div>
    <?php include('../../Pages/shared/html/footer.php'); ?>
</body>

</html>