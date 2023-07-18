<?php
// echo $_POST["firstName"] . "<br>";
// echo $_POST["lastName"] . "<br>";
// echo $_POST["birthday"] . "<br>";
// echo $_POST["phone"] . "<br>";
// echo $_POST["gender"] . "<br>";
// echo $_POST["address"] . "<br>";
// echo $_POST["email"] . "<br>";
// echo $_POST["account"] . "<br>";
// echo $_POST["password"] . "<br>";
// echo $_POST["confirmPassword"];
require_once("db_connect_small_project.php");
//users 資料庫讀取
$account = $_POST["account"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];
$now = date('Y-m-d H:i:s');
$sqlUsers = "INSERT INTO users (account, email, password, created_at, updated_at,vip ,valid) VALUES ('$account', '$email', '$password', '$now','$now' ,0,1)";

// $conn->close();
//users_Profile 資料庫讀取
$lastName = $_POST["lastName"];
$firstName = $_POST["firstName"];
$gender = $_POST["gender"];
$birthday = $_POST["birthday"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$sqlUsersProfile = "INSERT INTO `user_profile` (`last_name`, `first_name`, `gender`, `birthday`, `phone`, `address`) VALUES ('$lastName ', '$firstName', '$gender', '$birthday ','$phone' ,'$address')";

//驗證
if (isset($account) || isset($email) || isset($password) || isset($lastName) || isset($firstName) || isset($birthday) || isset($phone) || isset($address)) {
    die("請輸入資料");
}
if ($password != $confirmPassword) {
    die("密碼前後不一致");
}


//執行
$conn->query($sqlUsers);
$conn->query($sqlUsersProfile);
$conn->query("UPDATE user_profile SET  user_id= id"); //處理外鍵
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Password Reset - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .bg-keyboard {
            background-image: url("https://i.pinimg.com/564x/2a/36/aa/2a36aade4f27d271f15f01df08f2e518.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class=" bg-secondary">
    <a class="navbar-brand ps-3" href="index.html"> <img class="w-25 d-block mx-auto mt-3" src="橫logo白.svg" alt=""></a>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">新增會員成功</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">
                                        <h5>新增資料如下:</h5>
                                    </div>
                                    <div class="py-2 container">
                                        <table class="table table-bordered table-striped border-5 ">
                                            <tr class="row">
                                                <td class="col">Last Name</td>
                                                <td class="col"><?= $_POST["lastName"] ?></td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col">First Name</td>
                                                <td class="col"><?= $_POST["firstName"] ?></td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col">Birthday</td>
                                                <td class="col"><?= $_POST["birthday"] ?></td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col">Gender</td>
                                                <td class="col"><?= $_POST["gender"] == 1 ? "女" : "男" ?></td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col">Email</td>
                                                <td class="col"><?= $_POST["email"] ?></td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col">Password</td>
                                                <td class="col"><?= $_POST["password"] ?></td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="dashboard.php" class="text-dark">Go to dashboard</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>