<?php
require_once("../db_connect.php");

$id=$_GET["id"];

$sql="DELETE FROM rent WHERE id=$id";
if(($conn->query($sql)===TRUE)){
    header("location:rent_list.php");
}

// $sql="UPDATE rent SET valid=0 WHERE id=$id";

// if($conn->query($sql) === TRUE){
//     header("location:rent_list.php");
// }
$conn->close();