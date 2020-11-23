<?php
include('../session.php');
$titulo = "Panel de Administrados";
if ($isAdmin) {
    $btnsUD = '';
    $addNew = '<a class="btn btn-info btn-sm" href="create.php"><i class="fas fa-plus" aria-hidden="true"></i></a>';
} else {
    $addNew = "";
}

require("../config.php");
include '../Models/Post.php';
include '../Models/User.php';
include '../Clases/functions.php';
$counts = Post::GetCounts($conn, "comentarios");
if (isset($_GET['q']) && $_GET['q'] =="usuarios") {
    $users = User::GetAll($conn);
    echo json_encode($users, true);
    exit;
}

if (isset($_GET['q']) && $_GET['q'] =="entradas") {
    $posts = Post::GetAll($conn);
    echo json_encode($posts, true);
    exit;
}
if (isset($_GET['rol']) && isset($_GET['iduser']) ) {
    $isSuccess = User::UpdateRol($conn,$_GET['iduser'],$_GET['rol']);
    if($isSuccess){
        echo "ok";
    }else{
        echo "error";
    }
    exit;
}
$conn = null;
include('../pages/shared/html/head.php');
?>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="navbar-brand col-sm-2 col-md-2" href="../pages/posts/">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="manage" class="nav-link text-dark" title="Manage" href="/Identity/Account/Manage">
                        <i class="fas fa-user" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <form id="logoutForm" class="form-inline" action="/cuenta/salir?returnUrl=%2F" method="post">
                        <button id="logout" type="submit" class="nav-link btn btn-link text-dark">
                            <i class="fas fa-sign-out-alt" aria-hidden="true"></i></button>
                </li>
            </ul>

        </div>
    </nav>
    <div class="container-fluid mt-5 pt-2">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar pt-4">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <a href="./">
                            <li class="list-group-item list-group-item-action list-group-item-primary">
                            Inicio
                            </li>
                        </a>
                        
                        <li onclick="renderPartial(this)" class="list-group-item list-group-item-action list-group-item-primary">
                            Entradas
                        </li>
                        <li onclick="renderPartial(this)" class="list-group-item list-group-item-action list-group-item-primary">
                            Usuarios
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Configuración</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="list-group-item list-group-item-action list-group-item-primary">
                            Roles
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" id="mainContent" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="mt-4">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-info o-hidden h-100">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                                    </div>
                                    <div class="mr-5">
                                        <?php echo $counts->usersCount." Usuarios";?>
                                    </div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1" href="./">
                                    <span class="float-left">Ver Detalles</span>
                                    <span class="float-right">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-success o-hidden h-100">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fa fa-fw fa-newspaper-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="mr-5">
                                    <?php echo $counts->postsCount." Entradas";?>
                                    </div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1" href="./">
                                    <span class="float-left">Ver Detalles</span>
                                    <span class="float-right">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-warning o-hidden h-100">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="far fa-comments"></i>
                                    </div>
                                    <div class="mr-5">
                                     
                                        <?php echo $counts->commentsCount." Comentarios!";?>
                                    </div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1" href="/">
                                    <span class="float-left">Ver Detalles</span>
                                    <span class="float-right">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../Pages/shared/html/footer.php'); ?>
</body>

</html>
