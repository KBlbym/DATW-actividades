<header>
        <nav class="navbar navbar-expand-sm navbar-light navbar-toggleable-sm bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" href="../../../index.php">Blog</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a id="manage" class="nav-link text-dark" title="Manage" href="./Index.php">Hola, <?php echo $user->email ?></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" title="Cerrar sessión" href="/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/logout.php">cerrar session<i class="fas fa-sign-out-alt"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <main role="main" class="pb-1">
            <h1><?php echo $titulo;?></h1>
            <div>
                <h4>Cambio de la información de su cuenta</h4>
                <hr />