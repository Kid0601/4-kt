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
    <div class="modal fade" id="createCatModal_2_<?= $row1["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="createCatModal_2_<?= $row1["id"] ?>">僅新增子類別</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="doCreateCategory2.php">
                        <table class="table table-bordered">
                            <tr>
                                <th class="fs-5">商品類別名稱</th>
                                <td>
                                    <select class="form-select form-select-lg" aria-label=".form-select-lg example" name="parent_category">
                                        <?php foreach ($rows1 as $item) : ?>
                                            <option value="<?= $item['id']; ?>" <?php echo ($item['id'] == $parentCategoryId) ? 'selected' : ''; ?>>
                                                <?= $item['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="fs-5">子類別名稱</th>
                                <td>
                                    <input type="text" class="form-control" name="cat2_name">
                                </td>
                            </tr>
                        </table>
                        <div class="py-2 d-flex justify-content-end">
                            <button class="btn btn-success" type="submit">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>