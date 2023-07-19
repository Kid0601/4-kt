<?php
// 網頁 title
$title = "新增商品";

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
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">租用商品管理</li>
                        <li class="breadcrumb-item"><a href="rent_list.php" class="text-decoration-none text-reset"> 商品列表</a></li>
                        <li class="breadcrumb-item active">新增商品</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="doAdd.php" method="post">
                                <!-- <div class="py-3">
                                    <label for="">編號</label>
                                    <input type="text" class="form-control" name="id">
                                </div> -->
                                <div class="py-3">
                                    <label for="">名稱</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="py-3">
                                    <label for="">圖片</label>
                                    <input type="file" class="form-control" name="img" >
                                </div>
                                <div class="py-3">
                                    <label for="">簡介</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                                <div class="py-3">
                                    <label for="">租金</label>
                                    <input type="text" class="form-control" name="price">
                                </div>
                                <div class="py-3">
                                    <label for="">庫存</label>
                                    <input type="text" class="form-control" name="quantity">
                                </div>
                                <div class="py-3">
                                    <label for="">狀態</label>
                                    <select class="form-select" aria-label="Default select example" name="valid">
                                        <option value="0" selected>上架</option>
                                        <option value="1">下架</option>
                                    </select>
                                </div>
                                <div class="pt-3">
                                    <button class="btn btn-secondary" type="submit">儲存</button>
                                    <a class="btn btn-secondary" href="rent_list.php">取消</a>
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