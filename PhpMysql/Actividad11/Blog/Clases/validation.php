<?php
    class Validation {
        //PDO with Prepared Statements
        public static function  validateUserLoginPDO($context, $email,$pass){
            ////da un error si se cambia el variable resultado a result///
            
            $statment = $context->prepare("SELECT * FROM usuarios WHERE email= :email");
            $statment->bindParam(":email", $email);
            $statment->execute();
            $count=$statment->rowCount();
            if($count ==1){
                $userData=$statment->fetch(PDO::FETCH_OBJ);
                //$isPassValid = password_verify($pass, $userData->pass);
                $isPassValid = strcmp($pass, $userData->pass);
                if($isPassValid == 0){
                    return $userData; 
                }else{
                    return null;
                }
            }
            else{
                return null;
            }
        }
    }
?>
