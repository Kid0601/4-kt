<?php
// 取得所有類別 為了能夠選取並更改類別
// 類別一
$sqlCategory1 = "SELECT * FROM category_1";
$resultCate1 = $conn->query($sqlCategory1);
$category1 = $resultCate1->fetch_all(MYSQLI_ASSOC);
// 類別二
$sqlCategory2 = "SELECT * FROM category_2";
$resultCate2 = $conn->query($sqlCategory2);
$category2 = $resultCate2->fetch_all(MYSQLI_ASSOC);

// 將所有類別變成多維陣列
$allCate = array();
foreach ($category1 as $cate1) {
    $cate["cate1"] = $cate1["name"];
    $cate["cate2"] = array();
    foreach ($category2 as $cate2) {
        if ($cate2["parent_category"] == $cate1["id"]) {
            array_push($cate["cate2"], $cate2["name"]);
        }
    }
    array_push($allCate, $cate);
}
