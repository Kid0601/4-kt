<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}

require_once("../db_connect.php");

$id = $_GET["id"];

$sql = "UPDATE product SET valid = 0 WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    header("location: product-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();
