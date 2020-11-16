<?php
    class User{
        public $Id;
        public $Name;
        public $Email;
        public $Password;
        public $Rol;
        //public $IsEmailConfirmed = false;
        //public $IsActive = false;
        function __construct($id, $name, $email, $pass,$rol)
        {
            $this->Id = $id;
            $this->Name = $name;
            $this->Email = $email;
            $this->Password = $pass;
            $this->Rol = $rol;
            //$this->IsEmailConfirmed = $isEmailConfirmed;
            //$this->IsActive = $isActive;
        }

        public static function GetAll($context){
            $statment = $context->prepare("SELECT * FROM usuarios");
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                $usersData = $statment->fetchAll();
                return $usersData;
            }
            else{
                return null;
            }
        }

        public static function GetUserById($context,$id){
            $stmt = $context->prepare("SELECT * FROM usuarios WHERE id_user= :id");
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
            $statment = $context->prepare("INSERT INTO usuarios (nombre, email, rol, pass) VALUES (:nombre, :email, :rol, :pass)");
            $statment->bindParam(':nombre', $this->Name);
            $statment->bindParam(':email', $this->Email);
            $statment->bindParam(':rol', $this->Rol);
            $statment->bindParam(':pass', $this->Password);
            $statment->execute();
            $count=$statment->rowCount();
            if($count >= 1){
                return 1;
            }
            else{
                return 0;
            }
        }
        public function Update($context, $oldEmail){
            //si el email anterior es diferente al nuevo verificamos que el email no existe
            //en la base de tados.
            if($oldEmail != $this->Email){
                $stmtCheck = $context->prepare("SELECT email FROM usuarios WHERE email= :email");
                $stmtCheck->bindParam(':email', $this->Email);
                $stmtCheck->execute();
                $Mycount=$stmtCheck->rowCount();
                if($Mycount == 1){
                    return -1;
                }
            }

            //si retorna -1 email existe en la base de datos.
            //Si retorna 1 se han modificado los datos.
            //si Retorna 0 error no controlado
            $statment = $context->prepare("UPDATE usuarios SET nombre= :nombre, email=:email,rol=:rol,pass=:pass WHERE id_user= :id");
            $statment->bindParam(':id', $this->Id);
            $statment->bindParam(':nombre', $this->Name);
            $statment->bindParam(':email', $this->Email);
            $statment->bindParam(':rol', $this->Rol);
            $statment->bindParam(':pass', $this->Password);
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
            $statment = $context->prepare("DELETE FROM usuarios WHERE id_user= :id");
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