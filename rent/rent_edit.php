<?php

require_once("../db_connect.php");

$id = $_GET["id"];
$page=$_GET["page"];
$sql = "SELECT * FROM rent WHERE id=$id";
$result = $conn->query($sql);
// $rows= $result->fetch_all(MYSQLI_ASSOC);
$row = $result->fetch_assoc();
// var_dump($row);


// 網頁 title
$title = "商品編輯";

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
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="">訊息</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                確認刪除?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <!-- breadcrumb -->
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">租用商品管理</li>
                        <li class="breadcrumb-item"><a href="rent_list.php" class="text-decoration-none text-reset"> 商品列表</a></li>
                        <li class="breadcrumb-item active">商品編輯</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="doEdit.php" method="post">
                                <div class="pt-3">
                                    <label for="form-label" class="">編號</label>
                                    <input type="text" class="form-control-plaintext" readonly name="id" value="<?= $row["id"] ?>">
                                </div>
                                <div class="py-2">
                                    <label for="form-label">名稱</label>
                                    <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                </div>
                                <div class="py-2">
                                    <label for="">圖片</label>

                                    <input type="file" class="form-control" name="img" value="<?= $row["img"] ?>">
                                </div>
                                <div class="py-2">
                                    <label for="">簡介</label>
                                    <textarea class="form-control" name="description" rows="8"><?= $row["description"] ?></textarea>
                                </div>
                                <div class="py-2">
                                    <label for="">租金</label>
                                    <input type="text" class="form-control" name="price" value="<?= $row["price"] ?>">
                                </div>
                                <div class="py-2">
                                    <label for="">庫存</label>
                                    <input type="text" class="form-control" name="quantity" value="<?= $row["quantity"] ?>">
                                </div>
                                <div class="py-2">
                                    <label for="">狀態</label>
                                    <?php $valid = [
                                        "上架" => 0,
                                        "下架" => 1,
                                    ]  
                                    ?>
                                    <select class="form-select" aria-label="Default select example" name="valid">
                                        <?php foreach ($valid as $k => $v) :  ?>
                                            <option value="<?= $v ?>" <?php if ($row["valid"] == $v) echo 'selected' ?>><?= $k ?></option>
                                        <?php endforeach ?>
                                        <?php
                                        // if ($row["valid"] == 0) :
                                        ?>
                                            <!-- <option value="0" selected>上架</option>
                                            <option value="1">下架</option> -->
                                        <?php
                                        // elseif ($row["valid"] == 1) :
                                        ?>
                                            <!-- <option value="0">上架</option>
                                            <option value="1" selected>下架</option> -->
                                        <?php //endif ?>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between pt-3">
                                    <div>
                                        <button class="btn btn-secondary " type="submit">儲存</button>
                                        <a class="btn btn-secondary ms-3" href="rent_list.php?page=<?=$page?>">回到商品列表</a>
                                    </div>
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">刪除</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>
</body>

</html>