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
    <title>art_edit</title>
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
                <a class="my-3 btn btn-success" href="art_read.php?id=<?= $read_rows["id"] ?>">回上一頁</a>
                <a class="my-3 btn btn-success" href="article.php">回文章主頁</a>

                <form class="mt-3" action="doUpdate_art.php" method="POST" enctype="multipart/form-data">
                    <table class="table table-bordered ">
                        <input type="hidden" name="id" value="<?= $read_rows["id"] ?>">
                        <tr>
                            <th>標題</th>
                            <td>
                                <input name="title" class="w-100" type="text" value="<?= $read_rows["title"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>文章內容</th>
                            <td>
                                <textarea name="article" id="" cols="150" rows="10"><?= $read_rows["article"] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>文章類別</th>
                            <td>
                                <select name="article_category" class="form-select" aria-label="選擇類別">
                                    <option disabled>選擇類別</option>
                                    <option value="0" <?php if ($read_rows["article_category"] == "0") echo "selected"; ?>>公告</option>
                                    <option value="1" <?php if ($read_rows["article_category"] == "1") echo "selected"; ?>>開箱文</option>
                                    <option value="2" <?php if ($read_rows["article_category"] == "2") echo "selected"; ?>>組裝教學</option>
                                    <option value="3" <?php if ($read_rows["article_category"] == "3") echo "selected"; ?>>活動</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>已上傳圖片</th>
                            <td>
                                <input class="form-control" name="img[]" type="file" id="formFileMultiple" multiple>
                                <!-- <?php if (!empty($read_rows["img"])) : ?>
                                    <input type="hidden" name="img_prev" value="<?= $read_rows["img"] ?>">
                                    
                               <?php endif; ?> -->
                                <?= "目前所選: " . $read_rows["img"] ?>
                            </td>
                        </tr>
                        <tr>
                            <th>發佈日期</th>
                            <td><?= $read_rows["date"] ?></td>
                        </tr>
                        <tr>
                            <th>狀態</th>
                            <td>
                                <select name="valid" class="form-select" aria-label="選擇狀態">
                                    <option disabled>選擇狀態</option>
                                    <option value="0" <?php if ($read_rows["valid"] == "0") echo "selected"; ?>>下架</option>
                                    <option value="1" <?php if ($read_rows["valid"] == "1") echo "selected"; ?>>上架</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-success" type="submit">儲存</button>
                    </div>
                </form>

            </div>
</body>

</html>