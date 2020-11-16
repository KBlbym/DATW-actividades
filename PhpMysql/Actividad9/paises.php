<?php
include('admin/session.php');
    $titulo = "Paises";
    require("conection.php");
    include 'clases/MainClass.php';
    $result = MainClass::getCountries($conn);
    $htmlcontent="";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $htmlcontent .= "<tr>
            <td>".$row['Code']."</td>
            <td>".$row["Name"]."</td>
            <td>".$row["Capital"]."</td>
            <td>".$row["Code2"]."</td>
        </tr>";
        }
    }
    
?>
<?php
    include 'shared/html/head.php';
?>
<body>
<div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('shared/html/header.php');?>
        <main role="main" class="inner cover">
        
        <div class="card">
            <div class="card-header text-center bg-primary">
                <h2>Paises</h2>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Code2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $htmlcontent ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
<?php include('shared/html/footer.php');?>
</body>

</html>