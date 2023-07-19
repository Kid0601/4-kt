<?php
require_once("../db_connect.php");

$id = $_GET["id"];

$sql = "SELECT* FROM article WHERE id = $id ";
$result = $conn->query($sql);
$read_rows = $result->fetch_assoc();
// var_dump($read_rows);
?>

<!doctype html>
<html lang="en">

<head>
    <title>art_read</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<!-- head -->
<?php include("../template/head.php") ?>

<body class="sb-nav-fixed pe-0">
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">

            <div class="container">
                <div class="py-4">
                    <a class="btn btn-success" href="article.php">回上一頁</a>
                </div>
                <table class="table table-bordered ">
                    <tr>
                        <th>標題</th>
                        <td><?= $read_rows["title"] ?></td>
                    </tr>
                    <tr>
                        <th>文章內容</th>
                        <td><?= $read_rows["article"] ?></td>
                    </tr>
                    <tr>
                        <th>文章類別</th>
                        <td>
                            <?php
                            $article_category = $read_rows["article_category"];

                            switch ($article_category) {
                                case "0":
                                    echo "公告";
                                    break;
                                case "1":
                                    echo "開箱文";
                                    break;
                                case "2":
                                    echo "組裝教學";
                                    break;
                                case "3":
                                    echo "活動";
                                    break;
                            }; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>已上傳圖片</th>
                        <td>
                            <?php if ($read_rows["img"] != '""' && $read_rows["img"] != "") : ?>
                                <?php
                                $test = $read_rows["img"];
                                // echo $test;
                                $dataWithoutQuotes = str_replace('"', '', $test);
                                // echo $dataWithoutQuotes;
                                $arrayFromDatabase = explode(", ", $dataWithoutQuotes);
                                // print_r($arrayFromDatabase);
                                foreach ($arrayFromDatabase as $load_img) {
                                    echo "<img src=' ../article_img/$load_img' alt='圖檔連線失敗'>";
                                }
                                ?>
                            <?php else : ?>
                                <?= "無圖片" ?>
                            <?php endif; ?>

                            <!-- <img src="../article_img/<?= $arrayFromDatabase["2"] ?>" alt="圖檔連線失敗"> -->
                            <!-- <?= $read_rows["img"] ?> -->
                        </td>
                    </tr>
                    <tr>
                        <th>發佈日期</th>
                        <td><?= $read_rows["date"] ?></td>
                    </tr>
                    <tr>
                        <th>狀態</th>
                        <td><?php
                            $valid = $read_rows["valid"];

                            switch ($valid) {
                                case "0":
                                    echo "下架";
                                    break;
                                case "1":
                                    echo "上架";
                                    break;
                            }; ?></td>
                    </tr>
                    <tr>
                        <th>收藏會員</th>
                        <td><?php
                            $total_like = "SELECT article_id, user_id FROM article_like ";
                            $result_like = $conn->query($total_like);
                            $rows_like = $result_like->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows_like as $value) {
                                if ($id == $value['article_id']) {
                                    echo "No." . $value['user_id'] . "<br>";
                                }
                            }
                            ?></td>
                    </tr>
                </table>
                <div class="py-4 text-center">
                    <a class="btn btn-success" href="art_edit.php?id=<?= $read_rows["id"] ?>">編輯</a>
                </div>

            </div>
</body>

</html>