<?php
    class Post{
        public $Id;
        public $Title;
        public $Summary;
        public $Content;
        public $ImgName;
        public $DatePosted;
        public $IdCategory;
        public $IdUser;
        function __construct($id, $title, $summary, $content,$imgName, $datePosted, $idCategory, $idUser)
        {
            $this->Id = $id;
            $this->Title = $title;
            $this->Summary = $summary;
            $this->Content = $content;
            $this->ImgName = $imgName;
            $this->DatePosted = $datePosted;
            $this->IdCategory = $idCategory;
            $this->IdUser = $idUser;
        }

        public static function GetAll($context){
            
            $statment = $context->prepare("SELECT p.*,COALESCE(COUNT(comentarios.id_comentario)) AS commentsNum, u.nombre AS nombreU, c.nombre AS nombreC from posts AS p 
            inner join usuarios AS u on p.id_usuario = u.id_usuario 
            inner join categorias AS c on p.id_categoria = c.id_categoria
            left join comentarios on comentarios.id_post = p.id_post
            GROUP BY p.id_post");
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                $Data = $statment->fetchAll();
                return $Data;
            }
            else{
                return null;
            }
        }

        public static function GetById($context,$id){
            $stmt = $context->prepare("SELECT p.*, u.nombre AS nombreU, c.nombre AS nombreC from posts AS p 
            inner join usuarios AS u on p.id_usuario = u.id_usuario
            inner join categorias AS c on p.id_categoria = c.id_categoria
             WHERE id_post= :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count == 1){
                return $stmt->fetch(PDO::FETCH_OBJ);
            }
            else{
                return null;
            }
        }

        public static function GetPostsByCategory($context,$category){
            $stmt = $context->prepare("SELECT p.*, u.nombre AS nombreU, c.nombre AS nombreC from posts AS p 
            inner join usuarios AS u on p.id_usuario = u.id_usuario
            inner join categorias AS c on p.id_categoria = c.id_categoria WHERE c.nombre= :category");
            $stmt->bindParam(':category', $category);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count == 1){
                return $stmt->fetchAll();
            }
            else{
                return null;
            }
        }
        public static function GetCounts($context,$tableName){
            
            $statment = $context->prepare("SELECT  (SELECT COUNT(*) FROM   usuarios) AS usersCount,
            (SELECT COUNT(*) FROM   comentarios) AS commentsCount,
            (SELECT COUNT(*) FROM   posts) AS postsCount FROM dual");
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                return $statment->fetch(PDO::FETCH_OBJ);
            }
            else{
                return 0;
            }
        }
        public static function GetCommentsByPostId($context,$postId){
            $stmt = $context->prepare("SELECT c.*, u.nombre, u.id_usuario from comentarios AS c 
            inner join usuarios AS u on c.id_usuario = u.id_usuario WHERE c.id_post= :postId ORDER BY c.fechaComentario DESC");
            $stmt->bindParam(':postId', $postId);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count > 0){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
                return null;
            }
        }

        public static function AddComment($context,$comentario,$postId, $userId){
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
            $fechaComentario = date("Y-m-d H:i:s");
            $statment = $context->prepare("INSERT INTO comentarios (comentario, id_usuario, id_post,fechaComentario)
                    VALUES (:comentario, :id_usuario, :id_post, :fechaComentario)");
            $statment->bindParam(':comentario', $comentario);
            $statment->bindParam(':id_usuario', $userId);
            $statment->bindParam(':id_post', $postId);
            $statment->bindParam(':fechaComentario', $fechaComentario);
            $statment->execute();
            $count=$statment->rowCount();
            if($count == 1){
                return 1;
            }
            else{
                return 0;
            }
        }

        public function Add($context){
            //si retorna -1 titulo existe en la base de datos.
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
            $stmtCheck = $context->prepare("SELECT titulo FROM posts WHERE titulo= :titulo");
            $stmtCheck->bindParam(':titulo', $this->Title);
            $stmtCheck->execute();
            $Mycount=$stmtCheck->rowCount();
            if($Mycount == 1){
                return -1;
            }
            $statment = $context->prepare("INSERT INTO posts (titulo, resumen, contenido, imgName,fechaEntrada,id_categoria,id_usuario)
                    VALUES (:titulo, :resumen, :contenido, :imgName,:fechaEntrada,:id_categoria,:id_usuario)");
            $statment->bindParam(':titulo', $this->Title);
            $statment->bindParam(':resumen', $this->Summary);
            $statment->bindParam(':contenido', $this->Content);
            $statment->bindParam(':imgName', $this->ImgName);
            $statment->bindParam(':fechaEntrada', $this->DatePosted);
            $statment->bindParam(':id_categoria', $this->IdCategory);
            $statment->bindParam(':id_usuario', $this->IdUser);
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                return 1;
            }
            else{
                return 0;
            }
        }

        public function Update($context, $oldTitle){
            //si el titulo anterior es diferente al nuevo verificamos que el titulo no existe
            //en la base de tados.
            // if($oldEmail != $this->Email){
            //     $stmtCheck = $context->prepare("SELECT email FROM usuarios WHERE email= :email");
            //     $stmtCheck->bindParam(':email', $this->Email);
            //     $stmtCheck->execute();
            //     $Mycount=$stmtCheck->rowCount();
            //     if($Mycount == 1){
            //         return -1;
            //     }
            // }

            //si retorna -1 email existe en la base de datos.
            //Si retorna 1 se han modificado los datos.
            //si Retorna 0 error no controlado
            $fechaModificacion =  date("Y-m-d H:i:s");
            $statment = $context->prepare("UPDATE posts SET titulo=:titulo, resumen=:resumen, contenido=:contenido, imgName=:imgName,fechaModificacion=:fechaModificacion,id_categoria=:id_categoria,id_usuario=:id_usuario WHERE id_post= :id");
            $statment->bindParam(':id', $this->Id);
            $statment->bindParam(':titulo', $this->Title);
            $statment->bindParam(':resumen', $this->Summary);
            $statment->bindParam(':contenido', $this->Content);
            $statment->bindParam(':imgName', $this->ImgName);
            $statment->bindParam(':fechaModificacion',$fechaModificacion);
            $statment->bindParam(':id_categoria', $this->IdCategory);
            $statment->bindParam(':id_usuario', $this->IdUser);
            $statment->execute();
            $count=$statment->rowCount();
            if($count == 1){
                return 1;
                
            }
            else{
                return 0;
            }
        }

        public static function Delete($context,$id){
            $statment = $context->prepare("DELETE FROM posts WHERE id_post= :id");
            $statment->bindParam(':id', $id);
            $statment->execute();
            $count=$statment->rowCount();
            if($count == 1){
                return true;
            }
            else{
                return false;
            }
        }

    }
?>