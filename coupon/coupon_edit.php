<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    header("location: ../404.php");
}
$id = $_GET["id"];


$sql = "SELECT * FROM coupon WHERE id=$id";
$result = $conn->query($sql);
$coupon = $result->fetch_assoc();


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
                <div class="container-fluid px-4 pt-3">
                    <h2 class="py-2">優惠券_<?= $coupon["id"] ?></h2>
                    <form action="doUpdate.php?id=<?= $coupon["id"] ?>" method="post">
                        <table class="table table-bordered my-2">
                            <input type="hidden" name="id" value="<?= $coupon["id"] ?>">
                            <tr>
                                <th>編號</th>
                                <td><?= $coupon["id"] ?></td>
                            </tr>
                            <tr>
                                <th>
                                    <div>
                                        <?= !empty($coupon["coupon_name"]) ? "優惠券名稱" : "折扣碼名稱" ?>
                                        <input type="hidden" name="discount_category" value="<?= !empty($coupon["coupon_name"]) ? "ticket" : "code"; ?>"></input>
                                    </div>
                                </th>
                                <td><input type="text" class="form-control" value="<?php echo !empty($coupon["coupon_name"]) ? $coupon["coupon_name"] : $coupon["coupon_code"]; ?>" name="coupon"></td>
                            </tr>
                            <tr>
                                <th>優惠敘述</th>
                                <td><textarea name="description" id="description" rows="4" class="form-control"><?= $coupon["description"] ?></textarea></td>
                            </tr>
                            <tr>
                                <th>適用會員</th>
                                <td>
                                    <div class="mt-1" id="valid_check">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="membergrades" id="memberradio1" value="1" <?php
                                                                                                                                            if ($coupon["vip_id"] == 0) echo "checked"; ?>>
                                            <label class="form-check-label" for="memberradio1">一般會員</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="membergrades" id="memberradio2" value="2" <?php
                                                                                                                                            if ($coupon["vip_id"] == 1) echo "checked"; ?>>
                                            <label class="form-check-label" for="memberradio2">銀會員</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="membergrades" id="memberradio3" value="3" <?php
                                                                                                                                            if ($coupon["vip_id"] == 2) echo "checked"; ?>>
                                            <label class="form-check-label" for="memberradio3">金會員</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="membergrades" id="memberradio4" value="4" <?php
                                                                                                                                            if ($coupon["vip_id"] == 3) echo "checked"; ?>>
                                            <label class="form-check-label" for="memberradio4">全站</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>消費門檻</th>
                                <td><input type="text" class="form-control" value="<?= $coupon["threshold"]; ?>" name="threshold"></td>
                            </tr>
                            <tr>
                                <th>折扣</th>
                                <td>
                                    <select name="discount_type" id="discount_type" class="form-select mb-2">
                                        <option value=""></option>
                                        <option value="percent" <?php if (!empty($coupon["discount_percent"])) echo "selected"; ?>>百分比(%)</option>
                                        <option value="price" <?php if (!empty($coupon["discount_value"])) echo "selected"; ?>>金額(元)</option>
                                    </select>
                                    <?php if ($coupon["discount_percent"] != 0) : ?>
                                        <input type="text" class="form-control" value="<?= $coupon["discount_percent"] * 100 ?>" name="discount_percent">
                                    <?php else : ?>
                                        <input type="text" class="form-control" value="<?= $coupon["discount_value"] ?>" name="discount_value">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>開始日期</th>
                                <td>
                                    <?php if ($coupon["start_date"] == "0000-00-00 00:00:00") : ?>
                                        <input type="hidden" name="start_date" id="start_date" value="0000-00-00"></input>
                                        <span>會員註冊日</span>
                                    <?php else : ?>
                                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo date('Y-m-d', strtotime($coupon["start_date"])) ?>" style="width: 200px;">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>結束日期</th>
                                <td>
                                    <?php if ($coupon["end_date"] == "0000-00-00 00:00:00") : ?>
                                        <input type="hidden" name="end_date" id="end_date" value="0000-00-00"></input>
                                        <span>無限期</span>
                                    <?php else : ?>
                                        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo date('Y-m-d', strtotime($coupon["end_date"])) ?>" style="width: 200px;">
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <div class="py-2">
                            <button class="btn btn-info" type="submit">儲存</button>
                            <a href="coupon_list.php" class="btn btn-success">取消</a>
                        </div>
                    </form>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>

    <script>



    </script>
</body>

</html>