<?php
include('admin/session.php');
if(isset($_GET["country"]) && !empty($_GET["country"])){
    $titulo = "Ciudades de ".$_GET["country"];
    $pais=$_GET["country"];
    require("conection.php");
    include 'clases/MainClass.php';
    $result = MainClass::getCitiesByCountryName($conn, $_GET['country']);
    $htmlcontent="";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $htmlcontent .= "<tr>
                <td>".$row["ID"]."</td>
                <td>".$row["Name"]."</td>
                <td>".$row["population"]."</td>
            </tr>";
        }
        
        
    }
}
else{
    header('Location: index.php');
}
    
?>
<?php
    include 'shared/html/head.php';
?>
<body>
    <main class="main p-5" style="max-width: 680px;">
        <div class="card">
            <div class="card-header text-center bg-primary">
                <h2><?php echo $pais; ?></h2>
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