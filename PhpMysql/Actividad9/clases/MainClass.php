<?php
    class MainClass {
        public static function  getCountries($conn){
            $sql = "SELECT * FROM country";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }

        public static function  getCites($conn){
            $sql = "SELECT * FROM city";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }

        public static function  getCountryByCode($conn, $code){
            $sql = "SELECT * FROM country WHERE Code ='$code'";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }

        public static function  getAjaxSearch($conn, $query){
            $sql = "SELECT * FROM country WHERE Code LIKE '%$query%'";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }

        public static function  getCitiesByCountryName($conn, $countryName){
            $sql = "SELECT city.* FROM city INNER JOIN country
                    ON city.CountryCode=country.Code
                    WHERE country.Name = '$countryName'";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }
        

        public static function  getCitiesByCountryNameAjax($conn, $query){
            $sql = "SELECT country.Name
                FROM country WHERE country.Name LIKE '$query%'";
            $result =  $conn->query($sql);
            mysqli_close($conn); 
            return $result;
        }
        public static function  getUsersLoginMysqli($conn, $email,$pass){
            ////da un error si se cambia el variable resultado a result///
            //MySQLi with Prepared Statements
            $sql = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $resultado = $sql->get_result();
            $count = mysqli_num_rows($resultado);
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                
            }
            mysqli_close($conn); 
            return $resultado;

            //
        }
        //MySQLi with Prepared Statements
        public static function  validateUserLoginPDO($context, $email,$pass){
            ////da un error si se cambia el variable resultado a result///
            
            $statment = $context->prepare("SELECT * FROM usuarios WHERE email= :email");
            $statment->bindParam(":email", $email);
            $statment->execute();
            $count=$statment->rowCount();
            if($count ==1){
                $userData=$statment->fetch(PDO::FETCH_OBJ);
                //$isPassValid = password_verify($pass, $data->pass);
                $isPassValid = strcmp($pass, $userData->pass);;
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

        // public static function createCitiesTemplate($result){
            
        //     $htmlInner = "";
        //     if ($result->num_rows > 0) {
        //         while($row = $result->fetch_assoc()) {
        //             $htmlInner .="<tr>
        //             <td>".$row['ID']."</td>
        //             <td>".$row['Name']."</td>
        //             <td>".$row['population']."</td>
        //             </tr>";
        //         }
        //         return "<table>
        //         <tr>
        //             <th colspan='3'>Cities</th>
        //         </tr>
        //         <tr>
        //             <td>Id</td>
        //             <td>Name</td>
        //             <td>Population</td>
        //         </tr>
        //         ".$htmlInner."
        //         </table>";
        //     }
        //     else{
        //         echo "NO hay datos";
        //     }
        // }
    }
?>
