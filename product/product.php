<?php

if (!isset($_GET["id"]) || !isset($_GET["mode"])) {
    header("location: ../404.php");
}

$product_id = $_GET["id"];
// 編輯模式 or 資訊模式
$mode = $_GET["mode"];

require_once("../db_connect.php");
// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name, category_2.parent_category
        FROM product
        JOIN category_1 ON product.category_1 = category_1.id
        JOIN category_2 ON product.category_2 = category_2.id
        WHERE product.id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

$is_groupBuy = $product["is_groupBuy"];

// 團購資訊
$sqlGroupBuy = "SELECT * FROM group_buy WHERE product_id = $product_id";
$resultGroupBuy = $conn->query($sqlGroupBuy);
$groupBuy = $resultGroupBuy->fetch_assoc();

// input欄位是否readonly
if ($mode == "info") {
    $readonly = "disabled readonly";
} elseif ($mode == "edit") {
    $readonly = "";
} else {
    header("location: ../404.php");
}


// 網頁標題
$title = "商品 $product_id";

include("./include/getCategory.php");
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
                    <h1 class="mt-4">商品 <?= $product_id ?> <?= $mode == "edit" ? "編輯" : "詳細資訊" ?>
                    </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">
                            商品管理
                        </li>
                        <li class="breadcrumb-item">
                            <a href="product-list.php" class="link-dark">商品列表</a>
                        </li>
                        <li class="breadcrumb-item active">商品
                            <?= $product_id ?>
                        </li>
                    </ol>
                    <!-- 編輯表單 -->
                    <form action="doUpdate.php" method="post" enctype="multipart/form-data">
                        <div class="row mx-0 flex-column align-items-center">
                            <!-- 圖檔放在images/product數字，數字為類別一 -->
                            <figure class="text-center">
                                <img src="../images/product/<?= $product["img"] ?>" alt="<?= $product["img"] ?>" class="img-fluid">
                            </figure>
                            <div class="card p-3 col-8 mb-3">
                                <input type="hidden" name="id" value="<?= $product["id"] ?>">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="w-25">商品名稱</th>
                                        <td>
                                            <input type="text" value="<?= $product["name"] ?>" name="name" class="form-control" <?= $readonly ?> required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">品牌</th>
                                        <td>
                                            <input type="text" value="<?= $product["brand"] ?>" name="brand" class="form-control" <?= $readonly ?> required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品類別</th>
                                        <td class="d-flex align-items-center">
                                            <select name="category_1" id="category_1" class="form-control text-center w-25" <?= $readonly ?> required>
                                                <?php foreach ($allCate as $cate) : ?>
                                                    <option value="<?= $cate["cate1"] ?>" <?php if ($cate["cate1"] == $product["c1_name"])
                                                                                                echo "selected"; ?>><?= $cate["cate1"] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="px-3">/</span>
                                            <select name="category_2" id="category_2" class="form-control text-center w-25" <?= $readonly ?> required>
                                                <?php foreach ($allCate[$product["parent_category"] - 1]["cate2"] as $cate) : ?>
                                                    <option value="<?= $cate ?>" <?php if ($cate == $product["c2_name"])
                                                                                        echo "selected"; ?>><?= $cate ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品型態</th>
                                        <td>
                                            <input type="checkbox" name="is_groupBuy" data-toggle="toggle" data-onlabel="團購商品" data-offlabel="一般商品" data-onstyle="primary" data-offstyle="secondary" id="groupBuyCheck" <?= $readonly ?> <?= $product["is_groupBuy"] ? "checked" : "" ?>>
                                        </td>
                                    </tr>
                                    <?php if ($mode == "edit") : ?>
                                        <tr>
                                            <th>商品圖片</th>
                                            <td>
                                                <input type="file" name="img" class="form-control">
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th class="w-25">商品價格</th>
                                        <td>
                                            <input type="number" value="<?= $product["price"] ?>" name="price" min="0" class="form-control" <?= $readonly ?> required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品庫存</th>
                                        <td>
                                            <input type="number" value="<?= $product["quantity"] ?>" name="quantity" min="0" class="form-control" <?= $readonly ?> required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品描述</th>
                                        <td>
                                            <textarea name="description" cols="30" rows="10" class="form-control" style="resize: none" <?= $readonly ?>><?= $product["description"] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">上下架狀態</th>
                                        <td>

                                            <input type="checkbox" name="valid" data-toggle="toggle" data-onlabel="上架" data-offlabel="下架" data-onstyle="success" data-offstyle="danger" <?= $readonly ?> <?= $product["valid"] == 1 ? "checked" : "" ?>>


                                        </td>
                                    </tr>
                                    <tr class="groupBuyForm" style="display: none">
                                        <th class="w-25">團購時間</th>
                                        <td class="d-flex align-items-center">
                                            <input type="date" class="form-control" name="start" value="<?= $groupBuy["start"] ?>" <?= $readonly ?>>
                                            <span class="px-3">~</span>
                                            <input type="date" class="form-control" name="end" value="<?= $groupBuy["end"] ?>" <?= $readonly ?>>
                                        </td>
                                    </tr>
                                    <tr class="groupBuyForm" style="display: none">
                                        <th class="w-25">開團人數（現在/目標）</th>
                                        <td class="d-flex align-items-center">
                                            <input type="number" class="form-control w-25" name="current_people" value="<?= $groupBuy["current_people"] ?>" <?= $mode == "info" ? "disabled" : "" ?> readonly>
                                            <span class="px-3">/</span>
                                            <input type="number" name="target_people" class="form-control w-25" value="<?= $groupBuy["target_people"] ?>" <?= $readonly ?>>
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
    <?php include("../template/footerJs.php") ?>
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

        // 若選取團購，則顯示團購需要輸入的資訊
        function formDisplay(checkbox, element) {
            if (checkbox.checked) {
                element.forEach(item => {
                    item.style.display = "table-row";
                })
            } else {
                element.forEach(item => {
                    item.style.display = "none";
                })
            }
        }
        const groupBuyCheck = document.querySelector("#groupBuyCheck");
        const groupBuyForm = document.querySelectorAll(".groupBuyForm");

        formDisplay(groupBuyCheck, groupBuyForm);
        groupBuyCheck.addEventListener("change", function(e) {
            formDisplay(e.target, groupBuyForm);
        })
    </script>
</body>

</html>