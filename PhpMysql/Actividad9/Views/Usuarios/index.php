<?php
include('../../admin/session.php');
if($isAdmin){
$addNew = '<a class="btn btn-info btn-sm" href="create.php"><i class="fas fa-plus" aria-hidden="true"></i></a>';
}else{
    $addNew = "";

$titulo = "Bienvenido " . $_SESSION['name'];
require("../../PDOContext.php");
include '../../Models/User.php';

    $users = User::GetAll($conn);
    $conn =null;
?>

<?php
include('../../shared/html/head.php');
?>

<body class="text-center">
    <div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('../../shared/html/header.php'); ?>

        <h1>Usuarios</h1>

        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                        </div>
                        <div class="mr-5">
                            <span> <?php echo count($users); ?> Usuarios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header bg-secondary">
                    Usuarios
                    <div class="float-right">
                        <?php
                         echo "Hay ". count($users). " usuarios";
                         echo $addNew;
                         ?>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Rol
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($users as $user) {
                                    echo  "<tr>
                                    <td>".$user["id_user"]." </td>
                                    <td>".$user["nombre"]." </td>
                                    <td>".$user["email"]." </td>
                                    <td>".$user["rol"]." </td>
                                    <td>";
                                    if($isAdmin){
                                        echo "<div class=\"btn-group\">
                                        <a class=\"btn btn-outline-warning\" href=\"./edit.php?id=$user[id_user]\"><i class=\"far fa-edit\" aria-hidden=\"true\"></i></a>
                                        <a class=\"btn btn-danger\" href=\"./delete.php?id=$user[id_user]\"><i class=\"far fa-trash-alt\" aria-hidden=\"true\"></i></a>
                                        </div>";
                                    }
                                    echo "</td>
                                    </tr>";
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <?php include('../../shared/html/footer.php'); ?>
    </div>
    
</body>

</html>