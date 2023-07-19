<?php
require_once("../db_connect.php");

//$id=$_POST["id"];
$name=$_POST["name"];
$img=$_POST["img"];
$description=$_POST["description"];
$price=$_POST["price"];
$quantity=$_POST["quantity"];
$valid=$_POST["valid"];

// echo "$id, $name, $img, $description, $price, $quantity, $valid";
$sql="INSERT INTO rent (name, img, description, price, quantity, valid) VALUE('$name', '$img', '$description', '$price', '$quantity', '$valid')";

// echo $sql;

if($conn->query($sql) === TRUE){
    
    header("location:rent_list.php");
}else{
    echo "新增資料表錯誤: " . $conn->error;
}
$conn->close();