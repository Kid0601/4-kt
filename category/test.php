<?php
// create-category2.php

// 取得父類別ID
$parentCategoryId = isset($_GET['parent_category']) ? $_GET['parent_category'] : null;

// 資料庫查詢省略，留意下面的預設選項處理
?>

<!doctype html>
<html lang="en">

<head>
    <title>新增子類別</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="py-2">
            <a href="category-list.php" class="btn btn-info">回類別管理列表</a>
        </div>
        <form action="doCreateCategory2.php" method="post" class="w-50 m-auto d-flex flex-column align-items-start">
            <div class="mb-2">
                <label for="" class="fs-4">僅新增子類別</label>
                <select class="form-select form-select-lg" aria-label=".form-select-lg example" name="parent_category">
                    <?php foreach ($rows1 as $item) : ?>
                        <!-- 檢查是否與父類別ID相符，如果相符則將其設為預選選項 -->
                        <option value="<?= $item['id']; ?>" <?php echo ($item['id'] == $parentCategoryId) ? 'selected' : ''; ?>>
                            <?= $item['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="" class="fs-4">子類別</label>
                <input type="text" class="form-control" name="cat2_name">
            </div>
            <button class="btn btn-success" type="submit">送出</button>
        </form>
    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
