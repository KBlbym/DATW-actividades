<?php
 if(!empty($isAdmin) && $isAdmin){
     
?>
    <a href="../../Admin/" class="btn btn-secondary text-center mb-2">Panel de Administrador</a>
<?php
 }
?>
<header class="masthead mb-auto">
    <div class="inner">
        <h3 class="masthead-brand">Posts</h3>
        <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/index.php">Home</a>
            <a class="nav-link active" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/index.php?categoria=deporte">Deportes</a>
            <a class="nav-link active" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/index.php?categoria=historia">Historia</a>
            <a class="nav-link active" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/index.php?categoria=sucesos">Sucesos</a>
            <a class="nav-link active" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/index.php?categoria=teatro">Teatro</a>
            <?php
            if(isset($_SESSION['name'])){
                echo "<li class='nav-link'>hola, ".$_SESSION['name']."</li>";
                ?>
            <a class="nav-link" title="Cerrar sessión" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/logout.php"><i class="fas fa-sign-out-alt"></i></a>
            <?php
            }else{
                ?>
                <a class="nav-link" title="Iniciar session" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/login.php"><i class="fas fa-sign-in-alt"></i></a>
            <?php
            }
                
            ?>
        </nav>
    </div>
</header>