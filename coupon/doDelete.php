<!-- 此為完全刪除資料庫檔案 -->
<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}

$id = $_GET["id"];

require_once("../db_connect.php");

// echo $id;
$sql = "DELETE FROM coupon WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // echo "刪除成功";
    header("location: coupon_list.php");
} else {
    echo "刪除錯誤: " . $conn->error;
}

$conn->close();
?>