<?php
    $titulo = "Paises";
    require("conection.php");
    include 'clases/MainClass.php';
    $result = MainClass::getCites($conn);
    $htmlcontent="";
?>
<?php
    include 'html/head.php';
?>
<body>
    <main class="main p-5" style="max-width: 680px;">
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
</body>

</html>