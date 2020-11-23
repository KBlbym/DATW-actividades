<?php
    require("../../config.php");
    include '../../Models/Post.php';
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $isDeleted = Post::Delete($conn,$_GET['id']);
        if ($isDeleted) {
            echo  "ok";
        }else{
            echo "error";
        }
    }
?>