<?php
try {
    if(isset($_POST['code'])){
        $code = $_POST['code'];
        $conn = new mysqli("localhost", "root","", "world_x");

        $sql = "SELECT * FROM country WHERE Code ='$code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                print_r($row);
            }
        }
        
    }
    
} catch (\Throwable $th) {
    echo "Error";
    throw $th;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <input type="text" name="code" id="code">
        <input type="submit" value="buscar">
    </form>
</body>
</html>