<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
$title = "商品類別管理";
require_once("../db_connect.php");

$sql_1 = "SELECT category_1.* FROM category_1 WHERE valid=1 ORDER BY category_1.id ASC";
$result1 = $conn->query($sql_1);
$rows1 = $result1->fetch_all(MYSQLI_ASSOC);

$sql_2 = "SELECT category_2.* FROM category_2 WHERE valid=1 ORDER BY category_2.id ASC";
$result2 = $conn->query($sql_2);
$rows2 = $result2->fetch_all(MYSQLI_ASSOC);

// echo '<pre>';
// var_dump($rows1);
// var_dump($rows2);
// echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include("../template/head.php") ?>

<head>
    <style>
        .accordion-body::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body class="sb-nav-fixed pe-0">
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <!-- breadcrumb -->
                    <ol class="breadcrumb mb-4">
                        <!-- 你有幾層就複製幾個 -->
                        <li class="breadcrumb-item">商品類別管理</li>
                        <li class="breadcrumb-item active">總覽</li>
                    </ol>
                    <!-- 新增項目 -->
                    <div class="pt-4 pb-2 px-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCatModal">新增商品類別</button>
                        <div class="modal fade" id="createCatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-1" id="createCatModal">新增商品類別</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="doCreateCategory.php">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="fs-5">商品類別名稱</th>
                                                    <td>
                                                        <input type="text" name="cat1_name" id="cat1_name" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="fs-5">子類別名稱</th>
                                                    <td>
                                                        <input type="text" name="cat2_name" id="cat2_name" required>
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
                        <!-- on/off 全開/全關 -->
                        <div class="form-check form-switch" style="margin-right: 35px">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">ON/OFF</label>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($rows1 as $index => $row1) : ?>
                            <div class="col-md-4">
                                <div class="accordion accordion-toggleable" id="accordionPanelsStayOpenExample" style="width: 500px;">
                                    <div class="accordion-item m-3">
                                        <h2 class="accordion-header initial-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $index ?>" aria-expanded="false" aria-controls="panelsStayOpen-collapse<?= $index ?>">
                                                <a class="fs-4 text-dark" href="#" style="text-decoration: none;"><?= $row1["name"] ?></a>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse<?= $index ?>" class="accordion-collapse collapse">
                                            <!--  預設關閉的話class="accordion-collapse collapse"，預設開啟的話class="accordion-collapse" -->
                                            <div class="accordion-body">
                                                <?php $hasChildren = false; // 假設一開始沒有子項目 
                                                ?>
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($rows2 as $row2) : if ($row2["parent_category"] === $row1["id"]) : ?>
                                                            <?php $hasChildren = true; ?>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <?= $row2["name"] ?><a type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal_2_<?= $row2["id"] ?>"><i class="fa-solid fa-trash"></i></a>
                                                            </li>
                                                            <div class="modal fade" id="deleteModal_2_<?= $row2["id"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="">訊息</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            確定刪除 "<?= $row1["name"] ?>" 中的 "<?= $row2["name"] ?>"？
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                                            <a href="doDeleteCategory2.php?id=<?= $row2["id"] ?>" class="btn btn-danger">確認</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php if (!$hasChildren) : ?>
                                                    <p>目前沒有任何子類別</p>
                                                <?php endif; ?>
                                                <div class="btn-group mt-3" role="group" aria-label="Basic mixed styles example" style="float: right;">
                                                    <a type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCatModal_2_<?= $row1["id"] ?>">新增</a>
                                                    <a type="button" class="btn btn-warning" href="category-edit.php?id=<?= $row1["id"] ?>">編輯</a>
                                                    <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_1_<?= $row1["id"] ?>">刪除</a>
                                                </div>
                                                <div class="modal fade" id="createCatModal_2_<?= $row1["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-1">僅新增子類別</h1>
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
                                                                                        <option value="<?= $item['id']; ?>" <?php echo ($item['id'] == $row1["id"]) ? 'selected' : ''; ?>>
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
                                                <div class="modal fade" id="deleteModal_1_<?= $row1["id"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="">訊息</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                確定刪除 "<?= $row1["name"] ?>"？
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                                <a href="doDeleteCategory.php?id=<?= $row1["id"] ?>" class="btn btn-danger">確認</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--  accordion-body尾巴 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var switchElement = document.getElementById('flexSwitchCheckDefault');
                    var accordionElements = document.querySelectorAll('.accordion-toggleable');

                    switchElement.addEventListener('change', function() {
                        var isOpen = switchElement.checked;
                        accordionElements.forEach(function(accordion) {
                            var collapseElement = accordion.querySelector('.accordion-collapse');
                            if (isOpen) {
                                collapseElement.classList.add('show');
                            } else {
                                collapseElement.classList.remove('show');
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>
</body>

</html>