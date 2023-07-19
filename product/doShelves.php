<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}

require_once("../db_connect.php");

$id = $_GET["id"];
$sqlProduct = "SELECT valid FROM product WHERE id = '$id'";
$result = $conn->query($sqlProduct);
$product = $result->fetch_assoc();

if ($product["valid"] == 1) {
    $sql = "UPDATE product SET valid = -1 WHERE id = '$id'";
} elseif ($product["valid"] == -1) {
    $sql = "UPDATE product SET valid = 1 WHERE id = '$id'";
}

if ($conn->query($sql) === TRUE) {
    header("location: product-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();
