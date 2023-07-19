<?php

if(!isset($_POST["cat1_name"])){
    die("請依正常管道到此頁");
}

require_once("../db_connect.php");

$cat1_name = $_POST["cat1_name"];
$sql1 = "INSERT INTO category_1(name) VALUES ('$cat1_name')";

if ($conn->query($sql1) === TRUE) {
    $cat1_id = $conn->insert_id; // 獲取自動增量主鍵值

    $cat2_name = $_POST["cat2_name"];
    $sql2 = "INSERT INTO category_2(name, parent_category) VALUES ('$cat2_name', '$cat1_id')";

    if ($conn->query($sql2) === TRUE) {
        echo '<script>
                alert("新增成功");
                window.location.href = "category-list.php";
        </script>';
    } else {
        echo "新增資料錯誤: " . $conn->error;
    }
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();