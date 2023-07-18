<!-- 此為上架檔案 -->
<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}

$id = $_GET["id"];
require_once("../db_connect.php");

// echo $id;
$sql = "UPDATE coupon SET valid=1 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // echo "上架成功";
    header("location: coupon_list.php");
} else {
    echo "上架錯誤: " . $conn->error;
}

$conn->close();
?>
               