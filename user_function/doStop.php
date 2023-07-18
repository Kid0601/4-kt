<?php
require_once("db_connect_small_project.php");
$id = $_GET["id"];
echo $id;
$sql = "UPDATE users SET valid=0 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("location: stopuser.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
};
