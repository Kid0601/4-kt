<?php

if (!isset($_GET["id"])) {
    die("無法作業");
}
require_once("../db_connect.php");

$id = $_GET["id"];
// echo $id;

$sql = "UPDATE category_2 SET valid=0 WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo '<script>
                alert("刪除成功");
                window.location.href = "category-list.php";
        </script>';
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();
