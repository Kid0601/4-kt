<?php

require_once("../db_connect.php");
// 有資訊為空 跳回原頁面
// if (empty($_POST["name"]) || empty($_POST["cate_1"]) || empty($_POST["cate_2"]) || empty($_POST["price"]) || empty($_POST["desription"]) || empty($_POST["quantity"]) || empty($_POST["brand"]) || empty($_FILES["img"]["name"])) {
//     header("location: product-create.php");
//     exit;
// }
// if (isset($_POST["is_groupBuy"]) && (empty($_POST["start"]) || empty($_POST["end"]) || empty($_POST["target_people"]))) {
//     header("location: product-create.php");
//     exit;
// }

// 取得商品表單資訊
$name = $_POST["name"];
$cate_1 = $_POST["category_1"];
$cate_2 = $_POST["category_2"];
$price = $_POST["price"];
$img = $_FILES["img"]["name"];
$description = $_POST["description"];
$quantity = $_POST["quantity"];
$brand = $_POST["brand"];
$is_groupBuy = isset($_POST["is_groupBuy"]) ? 1 : 0;

// 取得類別
// 類別一
$sqlCategory1 = "SELECT c1_id FROM category_1 WHERE name = '$cate_1'";
$resultCate1 = $conn->query($sqlCategory1);
$cate_1 = $resultCate1->fetch_assoc()["c1_id"];
// 類別二
$sqlCategory2 = "SELECT c2_id FROM category_2 WHERE name = '$cate_2'";
$resultCate2 = $conn->query($sqlCategory2);
$cate_2 = $resultCate2->fetch_assoc()["c2_id"];

// ===== 新增商品操作 =====
// 先將auto increment 都設為最大值
// 先取得最大的 id
$sql_maxId = "SELECT MAX(id) AS max_id FROM product;";
$result_maxId = $conn->query($sql_maxId);
$row_maxId = $result_maxId->fetch_assoc();
$maxId = $row_maxId['max_id'];

// 將自動增量設置為最大的 id
$sql_resetAI = "ALTER TABLE product AUTO_INCREMENT = " . ($maxId + 1) . ";";
$conn->query($sql_resetAI);

// 開始新增商品
$sql1 = "INSERT INTO product (name, category_1, category_2, img, price, quantity, brand, is_groupBuy, valid, description)
    VALUE ('$name', '$cate_1', '$cate_2', '$img', '$price', '$quantity', '$brand', '$is_groupBuy', 1, '$description');";

if ($conn->query($sql1) === TRUE) {
    // 取得資料表新增當下的 id
    $latestId = $conn->insert_id;
    echo "商品id: " . $latestId . "<br>";
    echo "新增商品成功";
    // 上傳圖片到images/product資料夾
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


    // 假如為團購商品，就需要新增資訊進團購商品資料表
    if ($is_groupBuy == 1) {
        $start = $_POST["start"];
        $end = $_POST["end"];
        $target_people = $_POST["target_people"];
        // 團購資訊為空 跳回原頁面
        $sql_maxId = "SELECT MAX(id) AS max_id FROM group_buy;";
        $result_maxId = $conn->query($sql_maxId);
        $row_maxId = $result_maxId->fetch_assoc();
        $maxId = $row_maxId['max_id'];

        // 將自動增量設置為最大的 id
        $sql_resetAI = "ALTER TABLE group_buy AUTO_INCREMENT = " . ($maxId + 1) . ";";
        $conn->query($sql_resetAI);
        // 插入團購資訊
        $sql2 = "INSERT INTO group_buy (product_id, start, end, target_people, current_people)
                  VALUE ('$latestId', '$start', '$end', '$target_people', 0);";
        if ($conn->query($sql2) === TRUE) {
            echo "新增團購資訊成功";
        } else {
            echo "新增團購商品失敗";
        }
    }
    // 資料庫操作成功 回到指定的頁面
    header("location: product-list.php");
} else {
    echo "新增資料錯誤: " . $conn->error;
}

// 利用事務的方式做
// $conn->begin_transaction();
// try {
//     // 插入商品資料
//     $sql1 = "ALTER TABLE product AUTO_INCREMENT = 1;";

//     $sql1 .= "INSERT INTO product (name, category_1, category_2, img, price, quantity, brand, is_groupBuy, valid, description)
//     VALUE ('$name', '$cate_1', '$cate_2', '$img', '$price', '$quantity', '$brand', '$is_groupBuy', 1, '$description');";
//     $stmt1 = $conn->prepare($sql1);
//     $stmt1->execute();

//     $product_id = $conn->insert_id;

//     if ($is_groupBuy === 1) {
//         $start = $_POST["start"];
//         $end = $_POST["end"];
//         $target_people = $_POST["target_people"];
//         // 插入團購資訊
//         $sql2 = "ALTER TABLE group_buy AUTO_INCREMENT = 1;";
//         $sql2 .= "INSERT INTO group_buy (product_id, start, end, target_people, current_people)
//                   VALUE ('$product_id', '$start', '$end', '$target_people', 0);";
//         $stmt2 = $conn->prepare($sql2);
//         $stmt2->execute();
//     }
//     // 提交事務
//     $conn->commit();

//     echo "成功新增";
// } catch (Exception $e) {
//     // 錯誤就回滾事務
//     $conn->rollback();
//     echo "新增失敗" . $e->getMessage();
// }

$conn->close();
