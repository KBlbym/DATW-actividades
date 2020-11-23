<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/dfe4edbd6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <?php 
        $url = $_SERVER['PHP_SELF'];
        if(strpos(strtolower($url), "admin") === false){
        
    ?>
    <script defer src="https://use.fontawesome.com/releases/v5.11.2/js/all.js"></script>
    <link href="/DATW-DATABASES/PhpMysql/Actividad11/blog/www/css/style.css" rel="stylesheet">
    <link href="/DATW-DATABASES/PhpMysql/Actividad11/blog/www/css/cover.css" rel="stylesheet">
    <style>
        
        .btn-box {
            margin: 20px;
        }
        #showResult{
            display: block;
            position: absolute;
            z-index: 1;
        }
        ul{
            border: 1px solid;
            inset-inline-start: 0px;
        }
        li{
            list-style: none;
            background-color: bisque;
            /* border: 1px solid sandybrown; */
            cursor: pointer;
        }
    </style>
    <?php }else{?>
        <style>
            .nav li.list-group-item{
                cursor: pointer;
            }
        </style>
        <?php }?>

</head>