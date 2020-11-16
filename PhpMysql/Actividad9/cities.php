<?php
    include('admin/session.php');
    $titulo = "Paises";
    require("conection.php");
    include 'clases/MainClass.php';
    $result = MainClass::getCites($conn);
    $htmlcontent="";
?>
<?php
    include 'shared/html/head.php';
?>
<body>
<div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('shared/html/header.php');?>
        <main role="main" class="inner cover">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $htmlcontent .= "<tr>
                <td>".$row["ID"]."</td>
                <td>".$row["Name"]."</td>
                <td>".$row["population"]."</td>
            </tr>";
            }
        }
        
        ?>
        <div class="card">
            <div class="card-header text-center bg-primary">
                <h2>Ciudades</h2>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">population</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $htmlcontent ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <?php include('shared/html/footer.php');?>
</div>
</body>

</html>