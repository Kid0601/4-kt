<?php

$title = "新增商品";

require_once("../db_connect.php");

include("./include/getCategory.php");

// 取得已有的品牌 讓使用者能選擇
// $sqlBrand = "SELECT brand FROM ";
?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include("../template/head.php"); ?>

<body class="sb-nav-fixed pe-0">
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">新增商品</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">
                            商品管理
                        </li>
                        <li class="breadcrumb-item">
                            <a href="product-list.php" class="link-dark">商品列表</a>
                        </li>
                        <li class="breadcrumb-item active">
                            新增商品
                        </li>
                    </ol>
                    <!-- 編輯表單 -->
                    <form action="doCreate.php" method="post" enctype="multipart/form-data">
                        <div class="row mx-0 flex-column align-items-center">
                            <!-- 圖檔放在images/product數字，數字為類別一 -->
                            <div class="card p-3 col-8 mb-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="w-25">商品名稱</th>
                                        <td>
                                            <input type="text" name="name" class="form-control" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">品牌</th>
                                        <td>
                                            <input type="text" name="brand" class="form-control" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品類別</th>
                                        <td class="d-flex align-items-center">
                                            <select name="category_1" id="category_1" class="form-control text-center w-25">
                                                <option value="" disabled selected>類別一</option>
                                                <?php foreach ($allCate as $cate) : ?>
                                                    <option value="<?= $cate["cate1"] ?>"><?= $cate["cate1"] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="px-3">/</span>
                                            <select name="category_2" id="category_2" class="form-control text-center w-25">
                                                <option value="" disabled selected>類別二</option>
                                                <?php foreach ($allCate[$product["parent_category"] - 1]["cate2"] as $cate) : ?>
                                                    <option value="<?= $cate ?>"><?= $cate ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品型態</th>
                                        <td>
                                            <input type="checkbox" name="is_groupBuy" data-toggle="toggle" data-onlabel="團購商品" data-offlabel="一般商品" data-onstyle="primary" data-offstyle="secondary" id="groupBuyCheck">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>商品圖片</th>
                                        <td>
                                            <input type="file" name="img" class="form-control" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品價格</th>
                                        <td>
                                            <input type="number" name="price" min="0" class="form-control" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品庫存</th>
                                        <td>
                                            <input type="number" name="quantity" min="0" class="form-control" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">商品描述</th>
                                        <td>
                                            <textarea name="description" cols="30" rows="10" class="form-control" style="resize: none" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">上下架狀態</th>
                                        <td>
                                            <input checked disabled type="checkbox" name="valid" data-toggle="toggle" data-onlabel="上架" data-offlabel="下架" data-onstyle="success" data-offstyle="danger">
                                        </td>
                                    </tr>
                                    <tr class="groupBuyForm" style="display: none">
                                        <th class="w-25">團購時間</th>
                                        <td class="d-flex align-items-center">
                                            <input type="date" class="form-control" name="start">
                                            <span class="px-3">~</span>
                                            <input type="date" class="form-control" name="end">
                                        </td>
                                    </tr>
                                    <tr class="groupBuyForm" style="display: none">
                                        <th class="w-25">開團人數</th>
                                        <td>
                                            <input type="number" name="target_people" class="form-control">
                                        </td>
                                    </tr>
                                </table>
                                <!-- 編輯按鈕 -->
                                <div class="col d-flex justify-content-between mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-success">新增</button>
                                        <a href="product-list.php" class="btn btn-secondary mx-2">取消</a>
                                    </div>
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
            allCate[category1.selectedIndex - 1].cate2.forEach(item => {
                category2.innerHTML += `<option value='${item}' name='category_2'>${item}</option>`;
            });
        })

        // 若選取團購，則顯示團購需要輸入的資訊
        const groupBuyCheck = document.querySelector("#groupBuyCheck");
        const groupBuyForm = document.querySelectorAll(".groupBuyForm");
        groupBuyCheck.addEventListener("change", function(e) {
            if (e.target.checked) {
                groupBuyForm.forEach(item => {
                    item.style.display = "table-row";
                })
            } else {
                groupBuyForm.forEach(item => {
                    item.style.display = "none";
                })
            }
        })
    </script>
</body>

</html>