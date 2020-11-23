<?php
include('../../session.php');
$titulo = "Pagina de inicio";
if ($isAdmin) {
    $btnsUD = '';
    $addNew = '<a class="btn btn-info btn-sm" href="create.php"><i class="fas fa-plus" aria-hidden="true"></i></a>';
} else {
    $addNew = "";
}

require("../../config.php");
include '../../Models/Post.php';
include '../../Clases/functions.php';

if (isset($_GET['categoria'])) {
    $posts = Post::GetPostsByCategory($conn, $_GET['categoria']);
} else {
    $posts = Post::GetAll($conn);
}
$conn = null;
?>

<?php
include('../../Pages/shared/html/head.php');
?>

<body>
    <div class="container d-flex p-3 mx-auto flex-column">
        <?php include('../../Pages/shared/html/header.php'); ?>


        <div class="jumbotron bg-info mt-4">
            <h1 class="display-4">¡Bienevenido a blog ......</h1>
            <p class="lead"></p>
            <hr class="my-4">
            <a class="btn btn-primary btn-lg" href="../../Identity/Account/Manage/" role="button">Ver Perfil</a>
        </div>
        <div class="row">
            <?php
            if (!empty($addNew)) {
                echo '<div class="col-md-12 my-4">' . $addNew . '</div>';
            }
            if ($posts != null) {
                foreach ($posts as $post) {
            ?>
                    <div class="col-md-4  mb-4">
                        <div class="card shadow-sm bg-dark" id="post-id-<?php echo $post['id_post']; ?>">
                            <img src="../../www/img/posts/<?php echo $post['imgName'] ?>" class="card-img-top" title="<?php echo $post['titulo'] ?>" alt="<?php echo $post['titulo'] ?>">
                            <div class="card-body d-flex flex-column">
                                <?php echo $isAdmin == true ? btnsEditDelete($post['id_post']) : "" ?>
                                <h5 class="card-title"><?php echo $post['titulo'] ?></h5>
                                <p class="card-text"><?php echo $post['resumen'] ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn  btn-sm btn-outline-primary" role="button" href="./details.php?id=<?php echo $post['id_post'] ?>">Leer más »</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <small class="text-muted p-2">
                                    <span class="mr-4">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                        <?php echo $post['nombreU'] ?>
                                    </span>
                                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    <?php echo $post['fechaEntrada'] ?>
                                    <span class="fa-layers fa-fw">
                                        <i class="fas fa-comment fa-lg"></i>
                                        <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-5"><?php echo $post['commentsNum'] ?></span>
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>


    </div>
    <?php include('../../Pages/shared/html/footer.php'); ?>
</body>

</html>