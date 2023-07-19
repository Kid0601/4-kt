<?php
require_once("../db_connect.php");
if (!isset($_POST["title"])) {
    die("請依正常管道到此頁");
}

$title = $_POST["title"];
$article = $_POST["article"];
$article_category = $_POST["article_category"];
$now = date('Y-m-d H:i:s');
$valid = $_POST["valid"];
// $img =  $_FILES['img'];
// $imgs = $img["name"];

// $arr_jsonData = [];
// foreach ($imgs as $resutlts) {
//     $jsonData = json_encode($resutlts);
//     $arr_jsonData[] = $jsonData;
// }
// $jsonDataArrayString = implode(', ', $arr_jsonData);
include("json_encode.php");
$sql = "INSERT INTO article (title, article, article_category, date, valid, img) VALUES ('$title', '$article', '$article_category', '$now', '$valid', '$jsonDataArrayString')";

if ($conn->query($sql) === true) {
    $newID = $conn->insert_id;
    // echo "新增資料完成";
} else {
    echo "新增失敗" . $conn->error;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <title>doCreate_art</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

    <!-- 在頁面中加入 Modal 元件 -->
    <div class="modal fade" id="CreateModal" tabindex="-1" aria-labelledby="CreateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CreateModalLabel">新增成功，3秒後自動返回文章首頁</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    如不想等待、跳轉無反應，請點選"回文章首頁"
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" href="article.php">回文章主頁</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 等待頁面載入完成後執行
        document.addEventListener("DOMContentLoaded", function() {
            // 顯示彈出提示窗
            var go_back = new bootstrap.Modal(document.getElementById('CreateModal'));
            go_back.show();

            // 設定三秒後自動導向另一頁面
            setTimeout(function() {
                window.location.href = "article.php";
            }, 3000);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>