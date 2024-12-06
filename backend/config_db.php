<?php
$serverName = "RAFI"; 
$database = "tatib";          
$username = "rajend";                  
$password = "tampan";                  

try {
   $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error connecting to SQL Server : ".$e->getMessage());
}
?>