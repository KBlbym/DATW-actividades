<?php
    require("conection.php");
    include 'clases/MainClass.php';
    if(isset($_GET['q']) && !empty($_GET['q'])){
        $result = MainClass::getAjaxSearch($conn,$_GET['q']);
        $array = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row['Code'];
            }
        }
        echo json_encode($array);
    }else if(isset($_GET['country']) && !empty($_GET['country'])){
        $result = MainClass::getCitiesByCountryNameAjax($conn,$_GET['country']);
        $array = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row['Name'];
            }
        }
        echo json_encode($array);
    }
?>