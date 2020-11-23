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
$oldFileName ="";
//trear la entrada/post para modifircar
if(isset($_GET['id'])){
    $postToEdit = Post::GetById($conn, $_GET['id']);
    if($postToEdit ==null){
        header("HTTP/1.0 404 NOT FOUND");
        exit();
    }
    $oldFileName = $postToEdit->imgName;
}
else{
    header("HTTP/1.0 400 BAD REQUEST");
    exit();
}
//crear el usuario
if (isset($_POST['submit'])) {
    if (empty($_POST['titulo'])) {
        $error .= "Titulo es obligatorio<br>";
        $isFormValid = false;
    }else{
        $postToEdit->titulo = $_POST['titulo'];
    }
    if (empty($_POST['resumen'])) {
        $error .= "Resumen es obligatorio<br>";
        $isFormValid = false;
    }
    else{
        $postToEdit->titulo = $_POST['titulo'];
    }
    if (empty($_POST['contenido'])) {
        $error .= "El contenido es obligatorio<br>";
        $isFormValid = false;
    }
    else{
        $postToEdit->titulo = $_POST['titulo'];
    }
    if (empty($_POST['categoria'])) {
        $error .= "Selecciona una categoria<br>";
        $isFormValid = false;
    }
    else{
        $postToEdit->titulo = $_POST['titulo'];
    }
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        //si se selecciona una images nueva borraremos la anterior de la carpeta
        //Y guardar la nueva

        //validar el tipo de la images
        //si es valida, procesamos a borrar la antigua y guardad al nueva
        $imageName = ValidateFile();
        if(!$imageName){
            $error .= "Selectiona una imagen valida ('jpg', 'jpeg','png','gif')<br>";
            $isFormValid = false;
        } else {
            //carepta raiz de la imagenes
            $files_dir = "../../www/img/posts/";
            //la ruta de la image nueva
            $fullPath = $files_dir . basename($_FILES["image"]["name"]);

            //la ruta de la imagen anterior
            $odlFilePath = $files_dir . basename($oldFileName);
            //borrar la imagen anterior
            $isImageDeleted = removeFile($odlFilePath);
            if (!$isImageDeleted) {
                $error .= "Error al ententar guarda la imagen";
                $isFormValid = false;
            }
        }
        
    }
    if ($isFormValid) {
        saveFile($fullPath);
        $post = new Post($_GET['id'], $_POST['titulo'], $_POST['resumen'], $_POST['contenido'], $_FILES['image']['name'],null, $_POST['categoria'], $_SESSION['id_user']);
        
        //Si retorna 1 se han insertado los datos.
        //si Retorna 0 error no controlado
        //si retorna -1 entrada existe en la base de datos.
        $addPost = $post->Update($conn,null);

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
                        <input class="form-control" type="text" data-val="true" value="<?php echo $postToEdit==null ? "" : $postToEdit->titulo;?>" data-val-length="El Título No puede contener más de 150 caracteres" data-val-length-max="150" data-val-required="El campo de Título es obligatorio" id="titulo" maxlength="150" name="titulo">
                        <span class="text-danger field-validation-valid" data-valmsg-for="titulo" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="resumen">Discripción</label>
                        <textarea class="form-control" data-val="true" data-val-length="La Discripción No puede contener más de 250 caracteres" data-val-length-max="250" data-val-required="El campo de Discripción es obligatorio" id="resumen" maxlength="250" name="resumen"><?php echo $postToEdit==null ? "" : $postToEdit->resumen;?></textarea>
                        <span class="text-danger field-validation-valid" data-valmsg-for="resumen" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="contenido">Contenido</label>
                        <textarea class="form-control" id="contenido" data-val="true" data-val-required="El campo de Contenido es obligatorio" name="contenido"><?php echo $postToEdit==null ? "" : $postToEdit->contenido;?></textarea>
                        <span class="text-danger field-validation-valid" data-valmsg-for="contenido" data-valmsg-replace="true"></span>
                        
                    </div>
                    <div class="form-group">
                        <?php 
                        if(!empty($postToEdit->imgName)){
                            echo "<img src='../../www/img/posts/".$postToEdit->imgName."' height='80'/>";
                        }
                        ?>
                        <label class="control-label" for="image">File</label>
                        <input class="form-control" type="file"  id="image" name="image">
                        <span class="text-danger field-validation-valid" data-valmsg-for="image" data-valmsg-replace="true"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="categoria">Categoria</label>
                        <select class="form-control" data-val="true" data-val-required="Seleciona una categoria" id="categoria" name="categoria">
                            <?php
                              $selected ="";
                              if ($postToEdit->id_categoria == 1) {
                                  
                              }
                            ?>
                            <option value="1" <?php echo $postToEdit->id_categoria == 1 ? "selected" : "";?>>Deporte</option>
                            <option value="2" <?php echo $postToEdit->id_categoria == 2 ? "selected" : "";?>>Sucesos</option>
                            <option value="3" <?php echo $postToEdit->id_categoria == 3 ? "selected" : "";?>>Historia</option>
                            <option value="4" <?php echo $postToEdit->id_categoria == 4 ? "selected" : "";?>>Teatro</option>
                        </select>
                    </div>
                    <button name="submit" class="btn btn-lg btn-info btn-block" type="submit">Guardar</button>
                    
                </form>
            </div>
        </div>
        
    </div>
    <?php include('../../Pages/shared/html/footer.php'); ?>
</body>

</html>