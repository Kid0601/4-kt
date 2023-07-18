<?php

if (!isset($_GET["id"]) || !isset($_GET["mode"])) {
    header("location: ../404.php");
}

$product_id = $_GET["id"];
// 編輯模式 or 資訊模式
$mode = $_GET["mode"];

if ($mode == "info") {
    $readonly = "disabled readonly";
} elseif ($mode == "edit") {
    $readonly = "";
} else {
    header("location: ../404.php");
}

require_once("../db_connect.php");
// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name, category_2.parent_category
        FROM product
        JOIN category_1 ON product.category_1 = category_1.c1_id
        JOIN category_2 ON product.category_2 = category_2.c2_id
        WHERE product.id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// 網頁標題
$title = "商品 $product_id";

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
        if ($cate2["parent_category"] == $cate1["c1_id"]) {
            array_push($cate["cate2"], $cate2["name"]);
        }
    }
    array_push($allCate, $cate);
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include("../template/head.php") ?>

<body class="sb-nav-fixed pe-0">
    <!-- 確認刪除框框 -->
    <div class="modal fade" id="infoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>是否刪除?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a class="btn btn-danger" href="doDelete.php?id=<?= $product["id"] ?>">刪除</a>
                </div>
            </div>
        </div>
    </div>
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">商品 <?= $product_id ?> 詳細資訊
                    </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">
                            商品管理
                        </li>
                        <li class="breadcrumb-item">
                            商品列表
                        </li>
                        <li class="breadcrumb-item active">商品
                            <?= $product_id ?>
                        </li>
                    </ol>
                    <!-- 編輯表單 -->
                    <form action="doUpdate.php" method="post">
                        <div class="row mx-0 flex-column align-items-center">
                            <!-- 圖檔放在images/product數字，數字為類別一 -->
                            <figure class="text-center">
                                <img src="../images/product<?= $product["category_1"] ?>/<?= $product["img"] ?>" alt="<?= $product["img"] ?>" class="img-fluid">
                            </figure>
                            <div class="card p-3 col-8 mb-3">
                                <input type="hidden" name="id" value="<?= $product["id"] ?>">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>商品名稱</th>
                                        <td>
                                            <input type="text" value="<?= $product["name"] ?>" name="name" class="form-control" <?= $readonly ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>品牌</th>
                                        <td>
                                            <input type="text" value="<?= $product["brand"] ?>" name="brand" class="form-control" <?= $readonly ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>商品類別</th>
                                        <td class="d-flex align-items-center">
                                            <select name="category_1" id="category_1" class="form-control text-center w-25" <?= $readonly ?>>
                                                <?php foreach ($allCate as $cate) : ?>
                                                    <option value="<?= $cate["cate1"] ?>" <?php if ($cate["cate1"] == $product["c1_name"])
                                                                                                echo "selected"; ?>><?= $cate["cate1"] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="px-3">/</span>
                                            <select name="category_2" id="category_2" class="form-control text-center w-25" <?= $readonly ?>>
                                                <?php foreach ($allCate[$product["parent_category"] - 1]["cate2"] as $cate) : ?>
                                                    <option value="<?= $cate ?>" <?php if ($cate == $product["c2_name"])
                                                                                        echo "selected"; ?>><?= $cate ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>商品價格</th>
                                        <td>
                                            <input type="number" value="<?= $product["price"] ?>" name="price" min="0" class="form-control" <?= $readonly ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>商品庫存</th>
                                        <td>
                                            <input type="number" value="<?= $product["quantity"] ?>" name="quantity" min="0" class="form-control" <?= $readonly ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>商品描述</th>
                                        <td>
                                            <textarea name="description" cols="30" rows="10" class="form-control" style="resize: none" <?= $readonly ?>><?= $product["description"] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>上下架狀態</th>
                                        <td>
                                            <?php if ($product["valid"] == 1) : ?>
                                                <input type="checkbox" name="valid" checked data-toggle="toggle" data-onlabel="上架" data-offlabel="下架" data-onstyle="success" data-offstyle="danger" <?= $readonly ?>>
                                            <?php elseif ($product["valid"] == -1) : ?>
                                                <input type="checkbox" name="valid" data-toggle="toggle" data-onlabel="上架" data-offlabel="下架" data-onstyle="success" data-offstyle="danger" <?= $readonly ?>>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                <!-- 編輯按鈕 -->
                                <div class="col d-flex justify-content-between mb-0">
                                    <?php if ($mode == "info") : ?>
                                        <a href="product.php?mode=edit&id=<?= $product["id"] ?>" class="btn btn-success mx-2">編輯</a>
                                    <?php else : ?>
                                        <div>
                                            <button type="submit" class="btn btn-success">修改</button>
                                            <a href="product.php?mode=info&id=<?= $product_id ?>" class="btn btn-secondary mx-2">取消</a>
                                        </div>
                                        <div>
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#infoModal" id="deleteBtn">刪除</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>

    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        // 點選類別一的類別，類別二選單只會出現相對應的類別
        const allCate = <?= json_encode($allCate); ?>;
        console.log(allCate);
        const category1 = document.querySelector("#category_1");
        const category2 = document.querySelector("#category_2");
        category1.addEventListener("change", function() {
            category2.innerHTML = "";
            allCate[category1.selectedIndex].cate2.forEach(item => {
                category2.innerHTML += `<option value='${item}' name='category_2'>${item}</option>`;
            });
        })
    </script>
</body>

</html>