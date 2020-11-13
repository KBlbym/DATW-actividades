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
