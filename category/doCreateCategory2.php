<?php

if (!isset($_POST["cat2_name"])) {
    die("請依正常管道到此頁");
}

require_once("../db_connect.php");


$cat2_name = $_POST["cat2_name"];
$parent_category = $_POST["parent_category"];
$sql2 = "INSERT INTO category_2(name, parent_category) VALUES ('$cat2_name', '$parent_category')";

if ($conn->query($sql2) === TRUE) {
    echo '<script>
                alert("新增成功");
                window.location.href = "category-list.php";
        </script>';
} else {
    echo "新增資料錯誤: " . $conn->error;
}


$conn->close();
