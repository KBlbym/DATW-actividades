<?php
    class User{
        public $Id;
        public $Name;
        public $Email;
        public $Password;
        public $Apellidos;
        public $Telefono;
        public $Rol;
        public $EmailConfirmed;
        public $IsActive;
        function __construct($id, $name,$email, $pass,$rol,$emailConfirmed, $isActive)
        {
            $this->Id = $id;
            $this->Name = $name;
            $this->Email = $email;
            $this->Password = $pass;
            $this->Rol = $rol;
            $this->EmailConfirmed = $emailConfirmed;
            $this->IsActive = $isActive;
        }

        public static function GetAll($context){
            $statment = $context->prepare("SELECT u.*,COALESCE(COUNT(comentarios.id_comentario)) AS commentsNum from usuarios AS u 
            left join comentarios on comentarios.id_usuario = u.id_usuario
            GROUP BY u.id_usuario");
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                $usersData = $statment->fetchAll(PDO::FETCH_ASSOC);
                return $usersData;
            }
            else{
                return null;
            }
        }

        public static function GetUserById($context,$id){
            $stmt = $context->prepare("SELECT * FROM usuarios WHERE id_usuario= :id");
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


        public function Add($context){
            //si retorna -1 email existe en la base de datos.
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
            $stmtCheck = $context->prepare("SELECT email FROM usuarios WHERE email= :email");
            $stmtCheck->bindParam(':email', $this->Email);
            $stmtCheck->execute();
            $Mycount=$stmtCheck->rowCount();
            if($Mycount == 1){
                return -1;
            }
            $statment = $context->prepare("INSERT INTO usuarios (nombre, email, rol, pass, isActive, emailConfirmed)
             VALUES (:nombre, :email, :rol, :pass, :isActive, :emailConfirmed)");
            $statment->bindParam(':nombre', $this->Name);
            $statment->bindParam(':email', $this->Email);
            $statment->bindParam(':rol', $this->Rol);
            $statment->bindParam(':pass', $this->Password);
            $statment->bindParam(':isActive', $this->IsActive);
            $statment->bindParam(':emailConfirmed', $this->EmailConfirmed);
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                return 1;
            }
            else{
                return 0;
            }
        }
        public static function Update($context,$id,$nombre,$apellidos,$telefono){
            //Si retorna 1 se han modificado los datos.
            //si Retorna 0 error no controlado
            
            $statment = $context->prepare("UPDATE usuarios SET nombre= :nombre,apellidos=:apellidos,telefono=:tele WHERE id_usuario= :id");
            $statment->bindParam(':id', $id);
            $statment->bindParam(':nombre', $nombre);
            $statment->bindParam(':apellidos', $apellidos);
            $statment->bindParam(':tele', $telefono);
            $statment->execute();
            $count=$statment->rowCount();
            if($count == 1){
                return true;
            }
            else{
                return false;
            }
        }
        public static function UpdateEmail($context, $id, $email)
        {
            //si retorna -1 email existe en la base de datos.
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
            $stmtCheck = $context->prepare("SELECT email FROM usuarios WHERE email= :email");
            $stmtCheck->bindParam(':email', $email);
            $stmtCheck->execute();
            $Mycount = $stmtCheck->rowCount();
            if ($Mycount == 1) {
                return -1;
            }

            $statment = $context->prepare("UPDATE usuarios SET email= :email WHERE id_usuario= :id");
            $statment->bindParam(':id', $id);
            $statment->bindParam(':email', $email);
            $statment->execute();
            $count = $statment->rowCount();
            if ($count == 1) {
                return 1;
            } else {
                return 0;
            }
        }

        //cambiar contraseña
        public static function UpdatePassword($context, $id, $pass, $oldPass)
        {
            //si retorna 1 hay resultados o proceso realizado con exito.
            //Si retorna -1 la contraseña no es correcta.
            //si Retorna 0 error no controlado
            $user = User::GetUserById($context, $id);

            if ($user != null) {
                //comprara las contraseña si coinceden
                //$isPassValid = password_verify($oldPass, $user->pass);
                $isPassValid = strcmp($oldPass, $user->pass);
                if ($isPassValid == 0) {

                    //si las contraseñas son iguales procesamos a cambiar la contraseña vieja por la nueva
                    $statment = $context->prepare("UPDATE usuarios SET pass= :pass WHERE id_usuario= :id");
                    $statment->bindParam(':id', $id);
                    $statment->bindParam(':pass', $pass);
                    $statment->execute();
                    $count = $statment->rowCount();
                    if ($count == 1) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return -1;
                }
            } else {
                return 0;
            }
        }

        public static function UpdateRol($context, $id, $rol)
        {
            //Si retorna 1 se han insertado los datos.
            //si Retorna 0 error no controlado
            $statment = $context->prepare("UPDATE usuarios SET rol= :rol WHERE id_usuario= :id");
            $statment->bindParam(':id', $id);
            $statment->bindParam(':rol', $rol);
            $statment->execute();
            $count = $statment->rowCount();
            if ($count == 1) {
                return true;
            } else {
                return false;
            }
        }

        public static function Delete($context,$id){
            $statment = $context->prepare("DELETE FROM usuarios WHERE id_usuario= :id");
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