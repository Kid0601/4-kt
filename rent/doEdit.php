<?php
require_once("../db_connect.php");

$id=$_POST["id"];
$name=$_POST["name"];
$img=$_POST["img"];
$description=$_POST["description"];
$price=$_POST["price"];
$quantity=$_POST["quantity"];
$valid=$_POST["valid"];

// echo "$id, $name, $img, $description, $price, $quantity, $valid";

$sql="UPDATE rent SET name='$name', description='$description', price='$price', quantity='$quantity', valid='$valid' WHERE id=$id";
// echo $sql;








$sqlimg ="UPDATE rent SET img='$img' WHERE id=$id ";
if($img!=""){
    $conn->query($sqlimg);
}


if($conn->query($sql) === TRUE){
    header("location:rent_list.php");
}else{
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();