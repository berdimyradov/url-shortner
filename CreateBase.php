<?php
include 'Const.php';


function CreateDB($host,$user,$pass,$DBName)
{
   $conn = mysqli_connect($host, $user, $pass);
   
   if(! $conn ) {
       mysqli_close($conn);
       // Bu yerde oshibka ugratmaly
      die('Server informations is not valid: ' . mysqli_error());
   }
             
    $sql = 'CREATE DATABASE IF NOT EXISTS '.$DBName;
   mysqli_query( $conn,$sql );
    mysqli_close($conn);
}


   CreateDB($ServerHost,$UserName,$Password,$DBase);
   $conn = new mysqli($ServerHost, $UserName, $Password, $DBase);
   $command= "CREATE TABLE IF NOT EXISTS Links (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    LinkShorted VARCHAR(40) NOT NULL,
    LinkOriginal VARCHAR(255) NOT NULL,
    AddedTime DATETIME NOT NULL            
    )"; 
     $conn->query($command);
     $conn->close();

?>