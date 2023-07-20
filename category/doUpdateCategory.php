<?php

$cat1_id = $_POST["cat1_id"];
$cat1_name = $_POST["cat1_name"];
$cat2_id = $_POST["cat2_id"];
$cat2_name = $_POST["cat2_name"];

// var_dump($cat2_name);

require_once("../db_connect.php");

$sql1 = "UPDATE category_1 SET name='$cat1_name' WHERE id=$cat1_id";
mysqli_query($conn, $sql1);

foreach ($cat2_name as $index => $name) {
    $id = mysqli_real_escape_string($conn, $cat2_id[$index]);
    $name = mysqli_real_escape_string($conn, $name);
    $sql2 = "UPDATE category_2 SET name='$name' WHERE parent_category=$cat1_id AND id=$id";
    mysqli_query($conn, $sql2);
}

if ($conn->query($sql1) === TRUE & $conn->query($sql2) === TRUE) {
    echo '<script>
                alert("修改成功");
                window.location.href = "category-list.php";
        </script>';
} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();
