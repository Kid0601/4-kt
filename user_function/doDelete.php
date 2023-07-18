<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}
require_once("db_connect_small_project.php");
$id = $_GET["id"];
echo $id;
$sql = "DELETE FROM users WHERE id = $id ;";
$sqlUser = "DELETE FROM user_profile WHERE id = $id ;";
if ($conn->query($sql) === TRUE) {
    echo "刪除資料成功: ";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
if ($conn->query($sqlUser) === TRUE) {
    header("location: stopuser.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
