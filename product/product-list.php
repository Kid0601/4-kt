<?php
// 網頁 title
$title = "商品列表";

require_once("../db_connect.php");
// 商品型態(篩全部 一般商品 團購商品 下架商品)
$type = $_GET["type"] ?? "all";
$whereType = "";
switch ($type) {
    case "all":
        $whereType = "WHERE valid = 1 OR valid = -1";
        break;
    case "normal":
        $whereType = "WHERE (valid = 1 AND is_groupBuy = 0) OR (valid = -1 AND is_groupBuy = 0)";
        break;
    case "groupBuy":
        $whereType = "WHERE (valid = 1 AND is_groupBuy = 1) OR (valid = -1 AND is_groupBuy = 1)";
        break;
    case "off":
        $whereType = "WHERE valid = -1";
        break;
    default:
        break;
}

// 排序方式
$order = $_GET["order"] ?? "idASC";
$orderMethod = "";
switch ($order) {
    case "idASC":
        $orderMethod = "ORDER BY id ASC";
        break;
    case "idDESC":
        $orderMethod = "ORDER BY id DESC";
        break;
    case "nameASC":
        $orderMethod = "ORDER BY name ASC";
        break;
    case "nameDESC":
        $orderMethod = "ORDER BY name DESC";
        break;
    case "priceASC":
        $orderMethod = "ORDER BY price ASC";
        break;
    case "priceDESC":
        $orderMethod = "ORDER BY price DESC";
        break;
    case "quantityASC":
        $orderMethod = "ORDER BY quantity ASC";
        break;
    case "quantityDESC":
        $orderMethod = "ORDER BY quantity DESC";
        break;
    default:
        break;
}
// 搜尋
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$whereType = isset($_GET["search"]) ? "WHERE product.name LIKE '%$search%' OR product.brand LIKE '%$search%'" : $whereType;

// 分頁
$page = $_GET["page"] ?? 1;
$sqlTotal = "SELECT id FROM product $whereType $orderMethod";
$perPage = 10; // 一頁幾筆
$startItem = ($page - 1) * $perPage; // 第幾筆開始  


// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name
        FROM product
        JOIN category_1 ON product.category_1 = category_1.id
        JOIN category_2 ON product.category_2 = category_2.id
        $whereType
        $orderMethod
        LIMIT $startItem, $perPage";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

// 取得資料表 row 的數量(就是資料數量)
$product_count = $result->num_rows;
// 取得全部資料表資料的數量
$totalResult = $conn->query($sqlTotal);
$total_product = $totalResult->num_rows;

// 取得最多可以有幾頁
$lastPage = ceil($total_product / $perPage);


?>
<!DOCTYPE html>
<html lang="en">

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
                    <h1 class="mt-4"><?= $title ?></h1>
                    <!-- breadcrumb -->
                    <div class="d-flex justify-content-between align-items-start">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">商品管理</li>
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                        <div class="row justify-content-center align-items-center mx-0 gx-2">
                            <div class="col-auto">
                                <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="product-list.php">
                                    <div class="input-group">
                                        <input name="search" class="form-control" type="text" placeholder="搜尋商品名或品牌" aria-label="搜尋商品名或品牌" aria-describedby="btnNavbarSearch" />
                                        <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto">
                                <select name="type" id="type" class="form-control">
                                    <option value="all" <?php if (isset($_GET["type"]) && $_GET["type"] == "all") echo "selected" ?>>全部商品</option>
                                    <option value="normal" <?php if (isset($_GET["type"]) && $_GET["type"] == "normal") echo "selected" ?>>一般商品</option>
                                    <option value="groupBuy" <?php if (isset($_GET["type"]) && $_GET["type"] == "groupBuy") echo "selected" ?>>團購商品</option>
                                    <option value="off" <?php if (isset($_GET["type"]) && $_GET["type"] == "off") echo "selected" ?>>下架商品</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <a href="product-create.php" class="btn btn-info">
                                    <i class="fa-solid fa-circle-plus"></i> 新增
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="align-middle">
                                    <tr>
                                        <th>
                                            id
                                            <?php if (!isset($_GET["order"]) || $order == "idASC") : ?>
                                                <a href="product-list.php?order=idDESC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                            <?php else : ?>
                                                <a href="product-list.php?order=idASC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                            <?php endif; ?>
                                        </th>
                                        <th>
                                            商品名稱
                                            <?php if (!isset($_GET["order"]) || $order == "nameASC") : ?>
                                                <a href="product-list.php?order=nameDESC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                            <?php else : ?>
                                                <a href="product-list.php?order=nameASC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                            <?php endif; ?>
                                        </th>
                                        <th>品牌</th>
                                        <th>商品類別</th>
                                        <th>
                                            商品價格
                                            <?php if (!isset($_GET["order"]) || $order == "priceASC") : ?>
                                                <a href="product-list.php?order=priceDESC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                            <?php else : ?>
                                                <a href="product-list.php?order=priceASC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                            <?php endif; ?>
                                        </th>
                                        <th>
                                            商品庫存
                                            <?php if (!isset($_GET["order"]) || $order == "quantityASC") : ?>
                                                <a href="product-list.php?order=quantityDESC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                            <?php else : ?>
                                                <a href="product-list.php?order=quantityASC&type=<?= $type ?>" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                            <?php endif; ?>
                                        </th>
                                        <th>商品狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <!-- 確認刪除框框 -->
                                        <div class="modal fade" id="infoModal<?= $product["id"] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">確認刪除</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>是否刪除商品 <?= $product["id"] ?>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                        <a class="btn btn-danger" href="doDelete.php?id=<?= $product["id"] ?>">刪除</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 確認下架框框 -->
                                        <div class="modal fade" id="onOffModal<?= $product["id"] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">確認刪除</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php if ($product["valid"] == 1) : ?>
                                                            <p>是否下架商品 <?= $product["id"] ?>?</p>
                                                        <?php elseif ($product["valid"] == -1) : ?>
                                                            <p>是否上架商品 <?= $product["id"] ?>?</p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                        <?php if ($product["valid"] == 1) : ?>
                                                            <a class="btn btn-danger" href="doShelves.php?id=<?= $product["id"] ?>">下架</a>
                                                        <?php elseif ($product["valid"] == -1) : ?>
                                                            <a class="btn btn-success" href="doShelves.php?id=<?= $product["id"] ?>">上架</a>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td><?= $product["id"] ?></td>
                                            <td>
                                                <?= $product["name"] ?>
                                            </td>
                                            <td><?= $product["brand"] ?></td>
                                            <td><?= $product["c1_name"] ?> / <?= $product["c2_name"] ?></td>
                                            <td><?= $product["price"] ?></td>
                                            <td><?= $product["quantity"] ?></td>
                                            <td>
                                                <?php if ($product["is_groupBuy"] == 1) : ?>
                                                    <span class="badge bg-primary text-white">團購商品</span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary text-white">一般商品</span>
                                                <?php endif; ?>
                                                <?php if ($product["valid"] == 1) : ?>
                                                    <span class="badge bg-success text-white">上架</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger text-white">下架</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="product.php?mode=info&id=<?= $product["id"] ?>" title="詳細資訊" class="btn btn-link p-1">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
                                                    <a href="product.php?mode=edit&id=<?= $product["id"] ?>" title="編輯" class="btn btn-link p-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <button title="上下架" type="button" data-bs-toggle="modal" data-bs-target="#onOffModal<?= $product["id"] ?>" class="btn btn-link p-1 deleteBtn">
                                                        <?php if ($product["valid"] == 1) : ?>
                                                            <i class="fa-solid fa-circle-arrow-down"></i>
                                                        <?php elseif ($product["valid"] == -1) : ?>
                                                            <i class="fa-solid fa-circle-arrow-up"></i>
                                                        <?php endif; ?>
                                                    </button>
                                                    <button title="刪除" type="button" data-bs-toggle="modal" data-bs-target="#infoModal<?= $product["id"] ?>" class="btn btn-link p-1 deleteBtn">
                                                        <i class="fa-solid fa-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- 分頁 -->
                        <div class="py-2 d-flex justify-content-center">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="<?= $page - 1 < 1 ? "#" : "product-list.php?page=" . $page - 1 . "&type=$type&order=$order" ?>">&lt</a>
                                </li>
                                <!-- 算出可以有多少分頁數 -->
                                <?php for ($i = 1; $i <= $lastPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>">
                                        <a class="page-link" href="product-list.php?page=<?= "$i&type=$type&order=$order" ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class=" page-item">
                                    <a class="page-link" href="<?= $page + 1 > $lastPage ? "#" : "product-list.php?page=" . $page + 1 . "&type=$type&order=$order" ?>">&gt</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>
    <script>
        // 選單選擇就會轉到對應的商品列表
        const typeSelect = document.querySelector("#type");
        typeSelect.addEventListener("change", function() {
            location.href = `product-list.php?type=${typeSelect.value}`;
        })
    </script>
</body>

</html>