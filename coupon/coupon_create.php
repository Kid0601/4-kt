<?php
require_once("../db_connect.php");
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
                    <div class="py-2">
                        <a class="btn btn-success" href="coupon_list.php">
                            <i class="fa-solid fa-arrow-left"></i>
                            回優惠券列表
                        </a>
                    </div>
                    <h4 class="text-primary">新增優惠券/折扣碼</h4>
                    <form action="doCreate.php" method="post">
                        <div class="mt-3 mb-4">
                            <label for="">優惠種類</label>
                            <select name="discount_category" id="discount_category" class="form-select">
                                <option value=""></option>
                                <option value="ticket">優惠券</option>
                                <option value="code">折扣碼</option>
                            </select>
                        </div>
                        <div class="d-none" id="discount_content">
                            <div class="mb-3 d-flex flex-column row">
                                <label for="">適用會員</label>
                                <!-- <input type="text" class="form-control" name="valid" id="valid"> -->
                                <div class="mt-1" id="member_check">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membergrades" id="memberradio1" value="1">
                                        <label class="form-check-label" for="memberradio1">一般會員</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membergrades" id="memberradio2" value="2">
                                        <label class="form-check-label" for="memberradio2">銀會員</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membergrades" id="memberradio3" value="3">
                                        <label class="form-check-label" for="memberradio3">金會員</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membergrades" id="memberradio4" value="4">
                                        <label class="form-check-label" for="memberradio4">全站</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-end">
                                    <label for="" class="type_name"></label>
                                    <span class="text-danger d-none" id="type_ticket_msg"></span>
                                    <span class="text-danger d-none" id="type_code_msg"></span>
                                </div>
                                <input type="text" class="form-control d-none" name="type_ticket" id="type_ticket">
                                <input type="text" class="form-control mb-2 d-none" name="type_code" id="type_code" maxlength="10">
                                <button class="btn btn-primary d-none" id="random_code" type="button">隨機產生折扣碼</button>
                            </div>
                            <div class="mb-3">
                                <label for="">優惠敘述</label>
                                <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-end">
                                    <label for="">消費門檻(元)</label>
                                    <span class="text-danger threshold_text d-block">*門檻金額需為數字或無</span>
                                </div>
                                <input type="text" class="form-control" name="threshold" id="threshold" min="0" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="">折扣種類</label>
                                <select name="discount_type" id="discount_type" class="form-select">
                                    <option value=""></option>
                                    <option value="percent">百分比</option>
                                    <option value="price">金額</option>
                                </select>
                            </div>
                            <div class="mb-3" id="type_content">
                                <div class="d-flex justify-content-between align-items-end">
                                    <label for="" class="type_text"></label>
                                    <span class="text-danger type_price_text d-none">*需為10的倍數</span>
                                </div>
                                <input type="number" class="form-control d-none" name="type_percent" id="type_percent" maxlength="3" max="100" min="0">
                                <input type="text" class="form-control d-none" name="type_price" id="type_price">
                            </div>
                            <div class="mb-3">
                                <label for="">開始日期</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" style="width: 200px;">
                            </div>
                            <div class="mb-3">
                                <label for="">結束日期</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" style="width: 200px;">
                            </div>
                            <div class="mb-3 d-flex flex-column row">
                                <label for="">是否上架</label>
                                <!-- <input type="text" class="form-control" name="valid" id="valid"> -->
                                <div class="mt-1" id="valid_check">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes">
                                        <label class="form-check-label" for="inlineRadio1">是</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No">
                                        <label class="form-check-label" for="inlineRadio2">否</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-danger d-none">error</h6>
                        <button class="btn btn-info" type="submit" id="form_button">送出</button>
                    </form>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

    <script>
        function isNumber(value) {
            var patrn = /^(-)?\d+(\.\d+)?$/;
            if (patrn.exec(value) == null || value == "") {
                return false;
            } else {
                return true;
            }
        }
        const discount_category = document.querySelector("#discount_category");
        const type_name = document.querySelector(".type_name");
        const type_ticket = document.querySelector("#type_ticket");
        const type_code = document.querySelector("#type_code");
        const random_code = document.querySelector("#random_code");

        const discount_content = document.querySelector("#discount_content");

        const discount_type = document.querySelector("#discount_type");
        const type_content = document.querySelector("#type_content");
        const type_percent = document.querySelector("#type_percent");
        const type_price = document.querySelector("#type_price");

        const type_text = document.querySelector(".type_text");
        // const form_button = document.getElementById("form_button");

        discount_category.addEventListener("change", function() {
            // console.log(discount_category.value);
            type_text.innerText = "";
            discount_type.value = "";
            type_content.classList.add("d-none");
            if (discount_category.value != "") {
                discount_content.className = "d-block";
                if (discount_category.value == "ticket") {
                    type_name.innerText = "優惠券名稱";
                    type_ticket.className = "form-control d-block";
                    // type_code.className = "d-none";
                    type_code.classList.remove("d-block");
                    type_code.classList.add("d-none");
                    random_code.classList.remove("d-block");
                    random_code.classList.add("d-none");
                } else {
                    type_name.innerText = "折扣碼";
                    // type_code.className = "d-block";
                    type_ticket.className = "d-none";
                    type_code.classList.remove("d-none");
                    type_code.classList.add("d-block");
                    random_code.classList.remove("d-none");
                    random_code.classList.add("d-block");
                    type_code_msg.classList.remove("d-none");
                    type_code_msg.classList.add("d-block");
                    type_code_msg.innerText = "*折扣碼需為10碼大寫英數字串";
                    // form_button.setAttribute("disabled", "disabled");
                }
            } else
                discount_content.className = "d-none";

        });

        discount_type.addEventListener("change", function() {
            // console.log(discount_type.value);
            if (discount_type.value != "") {

                type_content.className = "d-block mb-3";
                if (discount_type.value == "percent") {
                    type_text.innerText = "折扣百分比(%)";
                    type_percent.className = "form-control d-block";
                    type_price.className = "d-none";
                } else {
                    type_text.innerText = "折扣金額(元)";
                    type_price.className = "form-control d-block";
                    type_percent.className = "d-none";
                }
            } else
                type_content.className = "d-none";
        });

        const threshold = document.querySelector("#threshold");
        threshold.addEventListener("keyup", function() {
            console.log("threshold " + this.value % 100);
            const threshold_text = document.querySelector(".threshold_text");
            if (!isNumber(this.value)) {
                if (this.value == "無") {
                    threshold_text.classList.remove("d-block");
                    threshold_text.classList.add("d-none");
                }
            } else {
                if (this.value < 0 || this.value > 20000) {
                    threshold_text.classList.remove("d-none");
                    threshold_text.classList.add("d-block");
                    threshold_text.innerText = "*門檻金額需介於0-20000";
                } else {
                    if (this.value % 100 != 0) {
                        console.log("門檻為100的倍數");
                        threshold_text.classList.remove("d-none");
                        threshold_text.classList.add("d-block");
                        threshold_text.innerText = "*需為100的倍數";
                    } else {
                        console.log("門檻不為100的倍數");
                        threshold_text.classList.remove("d-block");
                        threshold_text.classList.add("d-none");
                    }
                }
            }
        });

        type_price.addEventListener("keyup", function() {
            const type_price_text = document.querySelector(".type_price_text");
            if (this.value % 10 == 0) {
                type_price_text.classList.remove("d-block");
                type_price_text.classList.add("d-none");
            } else {
                type_price_text.classList.remove("d-none");
                type_price_text.classList.add("d-block");
            }
        })

        // if(discount_category.value && member_check)
        function generateRandomString(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charactersLength);
                result += characters.charAt(randomIndex);
            }
            // type_code.innerText = result;

            return result;
        }

        function isUpperCaseAndNumber(str) {
            // 檢查是否只包含英文大寫字母和數字的正則表達式
            var regex = /^[A-Z0-9]{10}$/;

            // 判斷字串是否符合正則表達式的條件和長度為 10
            return regex.test(str) && str.length === 10;
        }


        type_code.addEventListener("keyup", function() {
            if (isUpperCaseAndNumber(this.value)) {
                type_code_msg.classList.remove("d-block");
                type_code_msg.classList.add("d-none");
                // form_button.removeAttribute("disabled");
            }
        });
        random_code.addEventListener("click", function() {
            let res = generateRandomString(10);
            // console.log(res);
            type_code.value = res;
            type_code_msg.classList.remove("d-block");
            type_code_msg.classList.add("d-none");
            // form_button.removeAttribute("disabled");
        });
    </script>
</body>

</html>