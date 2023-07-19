<?php
if (isset($_GET["title"])) {
    $title = $_GET["title"];

    require_once("../db_connect.php");
    if (!empty($_GET["title"])) {
        $sql = "SELECT id, title, article_category, valid, date FROM article WHERE title LIKE '%$title%' ";
        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $user_count = $result->num_rows;
    } else {
        $user_count = 0;
    }
} else {
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>search_art</title>
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
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">搜尋結果</h1>
                    <!-- breadcrumb -->
                    <ol class="breadcrumb mb-4">
                        <!-- 你有幾層就複製幾個 -->
                        <li class="breadcrumb-item">文章主頁</li>
                        <li class="breadcrumb-item active">搜尋結果</li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body">
                            <div class="container">

                                <div class="py-4">
                                    <form action="search_art.php">
                                        <div class="row gx-2">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="搜尋使用者" name="title">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-info" type="submit">搜尋</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="py-2">
                                    <?php if (isset($_GET["title"])) : ?>
                                        <div>
                                            搜尋 "<?= $title ?>" 的結果, 共有 <?= $user_count ?> 筆符合的資料
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>編號</th>
                                            <th>標題</th>
                                            <th>分類</th>
                                            <th>發佈日期</th>
                                            <th>狀態</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($rows as $row) : ?>
                                            <tr>
                                                <td> <?= $row["id"] ?></td>
                                                <td> <?= $row["title"] ?></td>
                                                <td> <?php
                                                        $article_category = $row["article_category"];

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
                                                <td> <?= $row["date"] ?></td>
                                                <td><?php
                                                    $valid = $row["valid"];

                                                    switch ($valid) {
                                                        case "0":
                                                            echo "下架";
                                                            break;
                                                        case "1":
                                                            echo "上架";
                                                            break;
                                                    }; ?>
                                                </td>
                                                <td>
                                                    <a href="art_read.php?id=<?= $row["id"] ?>" class="btn btn-info">檢閱&編輯</a>

                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?= $row["id"] ?>">
                                                        刪除
                                                    </button>
                                                    <div class="modal fade" id="<?= $row["id"] ?>" tabindex="-1" aria-labelledby="<?= $row["id"] ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="<?= $row["id"] ?>">確定刪除文章編號<?= $row["id"] ?>嗎?</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    注意! 無法復原編號<?= $row["id"] ?>文章
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <a href="doDelete_art.php?id=<?= $row["id"] ?>" class="btn btn-danger">刪除</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <a class="btn btn-success" href="article.php">回文章主頁</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>