<?php 
$servername= "localhost";
$username= "root";
$password= "";
$dbname= "library";

try{
$conn=new PDO("mysql:host=$servername;port=3307;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo"Connected Successfully";
}
catch(PDOException $e){
die("Connection failed". $e->getMessage());
}

?>