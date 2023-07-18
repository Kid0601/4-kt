<!doctype html>
<html lang="en">

<head>
    <title>create_article</title>
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
                <div class="my-3">
                    <a class="btn btn-success" href="article.php">&lt;&lt;回上一頁</a>
                </div>
                <form class="" action="doCreate_art.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="">標題</label>
                        <input class="form-control" type="text" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="">文章內容</label>
                        <textarea class="form-control" rows="6" name="article"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">文章類別</label>
                        <select class="form-select" aria-label="article_category" name="article_category">
                            <option selected></option>
                            <option value="0">0 : 公告</option>
                            <option value="1">1 : 開箱文</option>
                            <option value="2">2 : 組裝教學</option>
                            <option value="3">3 : 活動</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">狀態</label>
                        <select class="form-select" aria-label="選擇狀態" name="valid">
                            <option selected></option>
                            <option value="0">下架</option>
                            <option value="1">上架</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">插入圖片檔</label>
                        <input class="form-control" name="img[]" type="file" id="formFileMultiple" multiple>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">送出</button>
                    </div>

                </form>
            </div>
</body>

</html>