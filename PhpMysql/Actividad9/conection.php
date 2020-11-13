<?php
try {
    $conn = new mysqli("localhost", "root","", "world_x");

} catch (\Throwable $th) {
    echo "Error";
    throw $th;
}
?>