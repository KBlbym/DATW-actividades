<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees";
    try {
            $context = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $context->prepare("SELECT * FROM employees WHERE emp_no= :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count == 1){
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                $xml = new SimpleXMLElement('<xml/>');
                
                $employee = $xml->addChild('employee'.$result->emp_no);
                $employee->addChild('first_name', $result->first_name);
                $employee->addChild('last_name', $result->last_name);
                $employee->addChild('gender', $result->gender);
                $employee->addChild('hire_date', $result->hire_date);
                
                Header('Content-type: text/xml');
                print($xml->asXML());
            }
            else{
                echo "no hay datos";
            }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

    }

?>