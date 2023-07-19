<?php
require_once("../db_connect.php");

// 接商品的資訊
$id = $_POST["id"];
// // 有資訊為空 跳回原頁面
// if (empty($_POST["name"]) || empty($_POST["cate_1"]) || empty($_POST["cate_2"]) || empty($_POST["price"]) || empty($_POST["desription"]) || empty($_POST["quantity"]) || empty($_POST["brand"]) || empty($_FILES["img"]["name"])) {
//     header("location: product.php?id=$id");
//     exit;
// }
// if (isset($_POST["is_groupBuy"]) && (empty($_POST["start"]) || empty($_POST["end"]) || empty($_POST["target_people"]))) {
//     header("location: product.php?id=$id");
//     exit;
// }
$name = $_POST["name"];
$brand = $_POST["brand"];
$price = $_POST["price"];
$description = $_POST["description"];
$cate_1 = $_POST["category_1"];
$cate_2 = $_POST["category_2"];
$quantity = $_POST["quantity"];
$is_groupBuy = isset($_POST["is_groupBuy"]) ? 1 : 0;
$valid = isset($_POST["valid"]) ? 1 : -1;
$start = $_POST["start"];
$end = $_POST["end"];
$target_people = $_POST["target_people"];
$current_people = $_POST["current_people"];
// 找原本圖片的名稱
$sqlImg = "SELECT img FROM product WHERE id = $id";
$resultImg = $conn->query($sqlImg);
$oldImg = $resultImg->fetch_assoc();
$img = empty($_FILES["img"]["name"]) ? $oldImg["img"] : $_FILES["img"]["name"];

// 取得類別
// 類別一
$sqlCategory1 = "SELECT id FROM category_1 WHERE name = '$cate_1'";
$resultCate1 = $conn->query($sqlCategory1);
$cate_1 = $resultCate1->fetch_assoc()["id"];
// 類別二
$sqlCategory2 = "SELECT id FROM category_2 WHERE name = '$cate_2'";
$resultCate2 = $conn->query($sqlCategory2);
$cate_2 = $resultCate2->fetch_assoc()["id"];

// echo $current_people;

// var_dump($_POST);
// var_dump($cate_2);

// 修改商品資訊
$sql = "UPDATE product
        SET name='$name', brand='$brand', price='$price', description='$description', quantity='$quantity', valid='$valid', category_1 = '$cate_1', category_2 = '$cate_2', is_groupBuy = '$is_groupBuy', img = '$img'
        WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    // 修改圖片
    if ($_FILES["img"]["error"] == 0) {
        $targetPath = "../images/product/";
        $targetFilePath = $targetPath . $_FILES["img"]["name"];
        if (!file_exists($targetFilePath)) {
            // 上傳檔案到指定路徑
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
                $filename =  $_FILES["img"]["name"];
                echo "上傳成功, 檔名為" . $filename;
            } else {
                echo "上傳失敗";
            }
        } else {
            var_dump($_FILES["img"]["error"]);
        }
    }
    // 選團購，新增或編輯團購資訊
    if ($is_groupBuy == 1) {
        $sqlGroupBuy = "SELECT product_id FROM group_buy WHERE product_id = '$id'";
        $resultGB = $conn->query($sqlGroupBuy);
        $infoGB = $resultGB->fetch_assoc();
        if (empty($infoGB)) {
            $sql_maxId = "SELECT MAX(id) AS max_id FROM group_buy;";
            $result_maxId = $conn->query($sql_maxId);
            $row_maxId = $result_maxId->fetch_assoc();
            $maxId = $row_maxId['max_id'];

            // 將自動增量設置為最大的 id
            $sql_resetAI = "ALTER TABLE group_buy AUTO_INCREMENT = " . ($maxId + 1) . ";";
            $conn->query($sql_resetAI);
            // 插入團購資訊
            $sql2 = "INSERT INTO group_buy (product_id, start, end, target_people, current_people)
                      VALUE ('$id', '$start', '$end', '$target_people', 0);";
            if ($conn->query($sql2) === TRUE) {
                echo "新增團購資訊成功";
            } else {
                echo "新增團購商品失敗";
            }
        } else {
            $sql2 = "UPDATE group_buy
            SET start='$start', end='$end', target_people='$target_people', current_people='$current_people'
            WHERE product_id=$id";
            if ($conn->query($sql2)) {
                echo "編輯團購資訊成功";
            } else {
                echo "編輯失敗";
            }
        }
    }
    header("location: product.php?mode=info&id=" . $id);
} else {
    echo "資料修改錯誤: " . $conn->error;
}

$conn->close();
