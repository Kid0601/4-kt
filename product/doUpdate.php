<?php
require_once("../db_connect.php");



// 接商品的資訊
$id = $_POST["id"];
$name = $_POST["name"];
$brand = $_POST["brand"];
$price = $_POST["price"];
$description = $_POST["description"];
$cate_1 = $_POST["category_1"];
$cate_2 = $_POST["category_2"];
$quantity = $_POST["quantity"];
$valid = isset($_POST["valid"]) ? 1 : -1;

// 取得類別
// 類別一
$sqlCategory1 = "SELECT c1_id FROM category_1 WHERE name = '$cate_1'";
$resultCate1 = $conn->query($sqlCategory1);
$cate_1 = $resultCate1->fetch_assoc()["c1_id"];
// 類別二
$sqlCategory2 = "SELECT c2_id FROM category_2 WHERE name = '$cate_2'";
$resultCate2 = $conn->query($sqlCategory2);
$cate_2 = $resultCate2->fetch_assoc()["c2_id"];

// var_dump($_POST);
// var_dump($cate_2);

// 修改商品資訊
$sql = "UPDATE product
        SET name='$name', brand='$brand', price='$price', description='$description', quantity='$quantity', valid='$valid', category_1 = '$cate_1', category_2 = '$cate_2'
        WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    header("location: product.php?mode=info&id=" . $id);
} else {
    echo "資料修改錯誤: " . $conn->error;
}

$conn->close();
