<?php
require_once("db_connect_small_project.php");
$sqlUserProfile = "SELECT * FROM user_profile";
$resultUserProfile = $conn->query($sqlUserProfile);
$rowsUserProfile = $resultUserProfile->fetch_all(MYSQLI_ASSOC);
$id = $_GET["id"];
$idA = $_GET["id"] - 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-secondary">
    <a class="navbar-brand ps-3" href="index.html"> <img class="w-25 d-block mx-auto mt-3" src="橫logo白.svg" alt=""></a>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h2 class="text-center font-weight-light my-4">Update Account</h2>
                                    <p>Last Name:<?= $rowsUserProfile[$idA]["last_name"] ?></p>
                                    <p>First Name:<?= $rowsUserProfile[$idA]["first_name"] ?></p>
                                    <p>Gender:<?= $rowsUserProfile[$idA]["gender"] == 1 ? "女" : "男" ?> </p>
                                    <p>Birthday:<?= $rowsUserProfile[$idA]["birthday"] ?></p>
                                    <p>Phone:<?= $rowsUserProfile[$idA]["phone"] ?></p>
                                    <p>Address:<?= $rowsUserProfile[$idA]["address"] ?></p>

                                </div>

                                <div class="card-body">
                                    <form action="doUpdateProfileUserUI.php?id=<?= $id ?>" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <h4 class="py-3">Last name</h4>
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputLastName" name="lastName" type="text" value="<?= $rowsUserProfile[$idA]["last_name"] ?>" placeholder="Enter your first name" />
                                                    <label class="text-secondary" for="inputLastName"><?= $rowsUserProfile[$idA]["last_name"] ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h4 class="py-3">First name</h4>
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputFirstName" name="firstName" type="text" value="<?= $rowsUserProfile[$idA]["first_name"] ?>" placeholder="Enter your last name" />
                                                    <label class="text-secondary" for="inputFirstName"><?= $rowsUserProfile[$idA]["first_name"] ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h4 class="py-3">Gender</h4>
                                                <div class="d-flex justify-content-between"></div>
                                                <select class="form-select form-select-sm w-75" aria-label=".form-select-sm example" id="gender" name="gender">
                                                    <label for="gender" class="w-25 "></label>

                                                    <option value="0">男</option>
                                                    <option value="1">女</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="py-3">Birthday</h4>
                                            <div class="form-floating">
                                                <input class="form-control" id="inputBirthday" name="birthday" type="text" value="<?= $rowsUserProfile[$idA]["birthday"] ?>" placeholder="Enter your last name" />
                                                <label class="text-secondary" for="inputBirthday"><?= $rowsUserProfile[$idA]["birthday"] ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="py-3">Phone</h4>
                                            <div class="form-floating">
                                                <input class="form-control" id="inputPhone" name="phone" type="text" value="<?= $rowsUserProfile[$idA]["phone"] ?>" placeholder="Enter your last name" />
                                                <label class="text-secondary" for="inputPhone"><?= $rowsUserProfile[$idA]["phone"] ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="py-3">Address</h4>
                                            <div class="form-floating">
                                                <input class="form-control" id="inputAddress" name="address" type="text" value="<?= $rowsUserProfile[$idA]["address"] ?>" placeholder="Enter your last name" />
                                                <label class="text-secondary" for="inputAddress"><?= $rowsUserProfile[$idA]["address"] ?></label>
                                            </div>
                                        </div>

                                </div>

                                <div class="col-6 mx-auto my-3 pt-3">
                                    <div class="d-grid"><input value="update" type="submit" class="btn btn-dark btn-block" href=""></input></div>

                                </div>
                                </form>

                            </div>

                            <div class="card-footer text-center">
                                <div class="small my-3"><a class="text-light" href=" dashboard.php">Go to dashboard</a></div>
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
                        <a class="text-muted" href="#">Privacy Policy</a>
                        &middot;
                        <a class="text-muted" href="#">Terms &amp; Conditions</a>
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