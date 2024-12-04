<?php
$serverName = "DESKTOP-EJS5FCV"; 
$database = "tatib";          
$username = "";                  
$password = "";                  

try {
   $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "koneksi berhasil";
}catch(PDOException $e){
    die("Error connecting to SQL Server : ".$e->getMessage());
}
?>