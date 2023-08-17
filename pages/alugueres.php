<?php

//connexão à BD;
$sname = 'localhost';
$unmae = 'root';
$password= "localhostMiguel";

$db_name = 'videoclub';

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    echo 'Connection Failed';
}

session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['name']) &&
    isset($_SESSION['email']) &&
    isset($_SESSION['age']) &&
    isset($_SESSION['role']) &&
    isset($_SESSION['nTel'])
) {

    $id = $_SESSION['id'];

    $usersSQL = "SELECT * FROM user WHERE id = '$id'";
    $userResult = $conn->query($usersSQL);

    $rentSQL = "SELECT * FROM aluguer WHERE userId = '$id' AND active = 0";
    $rentResult = $conn->query($rentSQL);

    $rentHistorySQL = "SELECT * FROM aluguer WHERE userId = '$id' AND active = 1";
    $rentHistoryResult = $conn->query($rentHistorySQL);
    ?>

    <html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>VideoClub</title>

        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../indexlogged.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">VideoClub</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../indexlogged.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                VideoClub
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Alugueres</span>
                </a>
            </li>

            <?php if ($_SESSION['role'] == 'Owner') { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="../indexadmin.php" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Página de Admin</span>
                    </a>
                </li>
                <?php } ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION[
                                    'name'
                                ]; ?></span>
                                <?php if (mysqli_num_rows($userResult) > 0) {
                                    foreach ($userResult as $row) {
                                        if (empty($row['profilePic'])) { ?>
                                            <img class="img-profile rounded-circle"
                                                 src="../img/undraw_profile.svg">

                                            <?php } else { ?>
                                            <img class="img-profile rounded-circle"
                                                 src="../userImages/<?= $row[
                                                     'profilePic'
                                                 ] ?>">

                                            <?php }
                                    }
                                } ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Alugueres</h1>
                    <br />

                    <br /> <br />

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Filme</th>
                                    <th>Data</th>
                                    <th>Tempo restante</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                    <?php if (mysqli_num_rows($rentResult) > 0) {
                        foreach ($rentResult as $row) {
                            $movieId = $row['movieId'];
                            $movieSQL = "SELECT * FROM movie WHERE id = '$movieId'";
                            $movieResult = $conn->query($movieSQL);
                            if (mysqli_num_rows($movieResult) > 0) {
                                foreach ($movieResult as $row2) { ?>

                                    <tr>
                                    <th><?= $row2['title'] ?></th>
                                    <th><?= $row['date'] ?></th>
                                    <th>1 semana</th>
                                    <th><form method="post">
                                            <a href="../processes/deliver.php?id=<?php echo $row[
                                                'id'
                                            ]; ?>">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-trash"></i>
                                                                    </span>
                                                <span class="text">Marcar como devolvido</span>
                                            </a>
                                        </form></th>
                                    </tr>

                            <?php }
                            }
                        }
                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <br />
                <br /><br />
                    <h1 class="h3 mb-2 text-gray-800">Histórico de Alugueres</h1>
                    <br />

                    <br /> <br />

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Filme</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (mysqli_num_rows($rentHistoryResult) > 0) {
                                    foreach ($rentHistoryResult as $row) {
                                        $movieId = $row['movieId'];
                                        $movieSQL = "SELECT * FROM movie WHERE id = '$movieId'";
                                        $movieResult = $conn->query($movieSQL);
                                        if (mysqli_num_rows($movieResult) > 0) {
                                            foreach ($movieResult as $row2) { ?>

                                                <tr>
                                                    <th><?= $row2['title'] ?></th>
                                                    <th><?= $row['date'] ?></th>
                                                </tr>

                                            <?php }
                                        }
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; VideoClub 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Logout" para terminar a sessão atual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="processes/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    </body>

    </html>
    <?php
} else {
    header('Location: login.php');
    exit();
}

?>
