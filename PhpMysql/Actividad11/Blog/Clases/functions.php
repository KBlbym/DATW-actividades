<?php
function ValidateFile()
{
    $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];

            //Traer un array pasado en punto
            $fileNameCmps = explode(".", $fileName);

            //traer el último elemento de array
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExtensions = array('jpg','jpeg','png','gif');

            //verificar si el archivo contiene la extension exacta 
            if (in_array($fileExtension, $allowedExtensions)) {
                return true;
            }
            else{
                return false;
            }
}
function saveFile($path)
    {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            return true;
        } else {
            return false;
        }
}
function btnsEditDelete($id){
        return '<div class="btn-group-sm">
        <a class="btn btn-outline-warning" href="./edit.php?id='.$id.'"><i class="far fa-edit" aria-hidden="true"></i></a>
        <li class="btn btn-danger" onclick="alertMessage('.$id.')"><i class="far fa-trash-alt" aria-hidden="true"></i></li>
        </div>';
}

    function removeFile($path){
        if (file_exists($path)) {
            if(unlink($path)){
                return true;
            }else {
                return false;
            }
        }
        else{
            return true;
        }
    }

    
?>
