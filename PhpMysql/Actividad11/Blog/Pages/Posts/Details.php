<?php
include('../../session.php');

$titulo = "";
require("../../config.php");
include '../../Models/Post.php';
include '../../Clases/functions.php';
//Añdir comentario 
if (isset($_POST['submitComment']) && !empty($_POST['comentario'])) {
    $addingComment = Post::AddComment($conn, $_POST['comentario'],$_GET['id'],$_SESSION['id_user']);
}
//trear la entrada/post
if (isset($_GET['id'])) {
    $post = Post::GetById($conn, $_GET['id']);
    $comments = Post::GetCommentsByPostId($conn, $post->id_post);
    $conn = null;
    if ($post == null) {
        header("HTTP/1.0 404 NOT FOUND");
        exit();
    }
} else {
    header("HTTP/1.0 400 BAD REQUEST");
    exit();
}

?>

<?php
include('../../Pages/shared/html/head.php');
?>

<body class="fluid-container">
    <?php include('../../Pages/shared/html/header.php'); ?>
    <div class="container-fluid header">
        <main class="pb-3">
            <header>
                <img class="img-fluid" src="../../www/img/posts/<?php echo $post->imgName ?>" alt="<?php echo $post->titulo ?>">
            </header>
            <div class="container  pt-4">
                <div class="row">
                    <article class="col-md-12">
                        <header>
                            <h1 class="text-center"><?php echo $post->titulo ?></h1>
                            <h5 class="lead">
                                <?php echo $post->resumen ?>
                            </h5>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <div>
                                        <small class="text-muted"><span class="mr-4"><i class="fas fa-user" aria-hidden="true"></i> <?php echo $post->nombreU ?> </span> <i class="far fa-calendar-alt" aria-hidden="true"></i> <?php echo $post->fechaEntrada ?></small>
                                    </div>
                                </div>

                            </div>
                        </header>
                        <hr>
                        <div>
                            <p><?php echo $post->contenido ?></p>
                        </div>
                    </article>
                    <hr class="my-4 w-100">
                    <article class="comentarios col-md-12">
                        <h2>Comentarios</h2>
                        <?php
                            if($isSignedIn){
                                echo '<form method="post" class="mb-4">
                                <div class="form-group">
                                    <label class="control-label" for="comentario">Comentario</label>
                                    <textarea class="form-control" id="comentario" data-val="true" data-val-required="El campo de Comentario es obligatorio" name="comentario"></textarea>
                                    <span class="text-danger field-validation-valid" data-valmsg-for="comentario" data-valmsg-replace="true"></span>
                                </div>
                                <button name="submitComment" class="btn btn-lg btn-info btn-block" type="submit">Comentar</button>
                            </form>';
                            }
                            else{
                                echo '<a href="../login.php" class="btn btn-lg btn-primary btn-block">Iniciar sessión</a>';
                            }
                        ?>
                        
                        <div class="list-group mt-4">
                            <?php
                            if ($comments != null) {
                                foreach ($comments as $comment) {
                            ?>
                                    <li href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?php echo $comment['nombre']; ?></h5>
                                            <small><?php echo $comment['fechaComentario']; ?></small>
                                        </div>
                                        <p class="mb-1"><?php echo $comment['comentario']; ?></p>
                                        <small><a href="">Eliminar (falta por añadir)</a></small>
                                    </li>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </article>
                </div>
            </div>
        </main>
    </div>
    <?php include('../../Pages/shared/html/footer.php'); ?>
</body>

</html>