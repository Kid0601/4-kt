<?php
require_once("db_connect_small_project.php");


//分頁功能
$page = $_GET["page"] ?? 1;
$startItem = ($page - 1) * 10;
//查詢停權名單資料庫
$sqlStop = "SELECT * FROM users WHERE valid=0 LIMIT $startItem,10";
$resultStop = $conn->query($sqlStop);
$rowsStop = $resultStop->fetch_all(MYSQLI_ASSOC);

//計算總頁數
$sqlPages = "SELECT * FROM users WHERE valid=0 ";
$resultTotalPages = $conn->query($sqlPages);
$totalPages = $resultTotalPages->num_rows;
$pages = ceil($totalPages / 10) //計算總共有幾頁
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html"> <img class="w-75" src="橫logo白.svg" alt=""></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form> -->
        <!-- Navbar-->
        <!-- <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul> -->
        <div class="text-end w-100 pe-3">
            <img style="width:100px;" src="/small_project/images/Keyboard-Traveler/橫字白.svg" alt="">
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- <div class="sb-sidenav-menu-heading"></div> -->
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            會員中心
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">會員中心 </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">共計:<?= $totalPages; ?> 筆</li>
                    </ol>
                    <!-- 停權名單 -->
                    <div class="stopUser card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            停權會員資料列表
                        </div>
                        <div class="card-body">
                            <!------------------------------------------------  輸入表格--------------------------------------------------------------->
                            <!-- id="datatablesSimple" 大絕 -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Account</th>
                                        <th>Password</th>
                                        <th>Email</th>
                                        <th>operation</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($rowsStop as $usersStop) :; ?>
                                        <tr>
                                            <td><?= $usersStop["id"]  ?></td>
                                            <td><?= $usersStop["account"]  ?></td>
                                            <td><?= $usersStop["password"]  ?></td>
                                            <td><?= $usersStop["email"]  ?></td>
                                            <td>
                                                <a href="doRecover.php?id=<?= $usersStop["id"] ?>" class="btn btn-dark">Recover</a>
                                                <a href="doDelete.php?id=<?= $usersStop["id"] ?>" class="btn btn-dark">刪除會員資料</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- 停權頁籤 -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $page - 1 ?>">Previous</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php endfor ?>
                            <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $page + 1 ?>">Next</a></li>
                        </ul>
                    </nav>


                    <div class="operation py-3">
                        <h3>管理者操作面板</h3>
                        <div class="operation-content">
                            <a href="/key_traveler/user_function/dashboard.php"><button class="btn btn-dark">回到會員資料</button></a>

                        </div>

                    </div>
                </div>


            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Key Traveler Website 2023</div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>