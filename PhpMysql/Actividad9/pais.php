<?php
include('admin/session.php');
if(isset($_GET["q"]) && !empty($_GET["q"])){
    $titulo = "";
    $pais="";
    require("conection.php");
    include 'clases/MainClass.php';
    $result = MainClass::getCountryByCode($conn, $_GET['q']);
    $htmlcontent="";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $titulo = $row["Name"];
            $pais = $row["Name"];
            $htmlcontent .= "<tr>
            <td>".$row["Code"]."</td>
            <td>".$row["Name"]."</td>
            <td>".$row["Capital"]."</td>
            <td>".$row["Code2"]."</td>
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
</body>

</html>