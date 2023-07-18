<?php
require_once("db_connect_small_project.php");
$sqlUser = "SELECT * FROM users";
$resultUser = $conn->query($sqlUser);
$rowsUser = $resultUser->fetch_all(MYSQLI_ASSOC);
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
    <title>Update - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-secondary">
    <a class="navbar-brand ps-3" href="index.html"> <img class="w-25 d-block mx-auto mt-1 mb-0" src="橫logo白.svg" alt=""></a>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h2 class="text-center font-weight-light my-4">Update Account</h2>
                                    <h4>Account:<?= $rowsUser[$idA]['account'] ?></h4>
                                    <h4>Password:<?= $rowsUser[$idA]['password'] ?></h4>
                                    <h4>Password:<?= $rowsUser[$idA]['email'] ?></h4>
                                </div>

                                <div class="card-body">
                                    <form action="doUpdateUser.php?id=<?= $id ?>" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <h4 class="py-3">Account</h4>
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputAccount" name="account" type="text" placeholder="Enter your first name" />
                                                    <label for="inputAccount">Account</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h4 class="py-3">Password</h4>
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputPassword" name="password" type="text" placeholder="Enter your last name" />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h4 class="py-3">Email</h4>
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputEmail" name="email" type="text" placeholder="Enter your last name" />
                                                    <label for="inputEmail">Email</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-6 mx-auto my-3 pt-3">
                                            <div class="d-grid"><input value="update" type="submit" class="btn btn-dark btn-block" href=""></input></div>

                                        </div>
                                    </form>

                                </div>

                                <div class="card-footer text-center">
                                    <div class="small"><a href="dashboard.php" class="text-secondary">Go to dashboard</a></div>
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