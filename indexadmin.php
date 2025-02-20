<?php

//connexão à BD;
$sname= "localhost";
$unmae= "root";
$password= "root";

$db_name= "videoclub";

$conn= mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection Failed";

}

$usersSQL = "SELECT * FROM user ORDER BY id DESC";
$userResult = $conn->query($usersSQL);

$moviesSQL = "SELECT * FROM movie ORDER BY id DESC";
$movieResult = $conn->query($moviesSQL);

$rentSQL = "SELECT * FROM aluguer WHERE active=0 ORDER BY id DESC";
$rentResult = $conn->query($rentSQL);

session_start();
if (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['age']) && isset($_SESSION['role']) && isset($_SESSION['nTel'])) {
    if ($_SESSION['role'] == 'Owner') {

        $id2 = $_SESSION['id'];

        $usersSQL = "SELECT * FROM user WHERE id = '$id2'";
        $userPictureResult = $conn->query($usersSQL);

    ?>

    <html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>VideoClub - Admin</title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <script src=”https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js”></script>
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

        <script>
            $(document).ready( function () {
                $('#dataTable').DataTable();
            } );
        </script>

    </head>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexadmin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">VideoClub</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="indexadmin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="indexlogged.php" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Ver website</span>
                </a>
            </li>

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?></span>
                                <?php
                                if (mysqli_num_rows($userPictureResult) > 0) {
                                    foreach ($userPictureResult as $row) {
                                        if (empty($row['profilePic'])){
                                            ?>
                                            <img class="img-profile rounded-circle"
                                                 src="img/undraw_profile.svg">

                                            <?php
                                        } else {
                                            ?>
                                            <img class="img-profile rounded-circle"
                                                 src="userImages/<?=$row['profilePic']?>">

                                            <?php
                                        }
                                    }
                                }

                                ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="./pages/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
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

                    <h1 class="h3 mb-2 text-gray-800">Admin</h1>
                    <br />
                    <div class="card shadow mb-4">
                        <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Utilizadores</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                     aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Opções:</div>
                                    <a class="dropdown-item" href="./pages/adduser.php">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Morada</th>
                                        <th>Telemóvel</th>
                                        <th>Idade</th>
                                        <th>Cargo</th>
                                        <th>Ativo</th>
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if (!empty($userResult)) {
                                            foreach ($userResult as $row) {
                                                if ($row['active'] == 1) {
                                                    echo "<tr>";
                                                        echo "<th>";
                                                            echo $row['name'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo $row['email'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo $row['address'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo $row['nTel'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo $row['age'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo $row['role'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                            echo "Sim";
                                                        echo "</th>";
                                                        echo "<th>";
                                                        ?>
                                                            <form method="post">
                                                                <a href="processes/desactivateuser.php?id=<?php echo $row['id']?>&name=<?php echo $row['name']?>">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-trash"></i>
                                                                    </span>
                                                                    <span class="text">Desativar utilizador</span>
                                                                </a>
                                                            </form>
                                                        <?php
                                                        echo "</th>";
                                                    echo "</tr>";
                                                } else if ($row['active'] == 0){
                                                    echo "<tr>";
                                                    echo "<th>";
                                                    echo $row['name'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo $row['email'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo $row['address'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo $row['nTel'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo $row['age'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo $row['role'];
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo "Não";
                                                    echo "</th>";
                                                    echo "<th>";
                                                    ?>
                                                    <form method="post">
                                                        <a href="processes/activateuser.php?id=<?php echo $row['id']?>&name=<?php echo $row['name']?>">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-trash"></i>
                                                                    </span>
                                                            <span class="text">Ativar utilizador</span>
                                                        </a>
                                                    </form>
                                                    <?php
                                                    echo "</th>";
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Filmes</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                     aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Opções:</div>
                                    <a class="dropdown-item" href="./pages/addmovie.php">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Descricao</th>
                                        <th>Data de Lancamento</th>
                                        <th>Rating</th>
                                        <th>Cast</th>
                                        <th>Producao</th>
                                        <th>Generos</th>
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($movieResult)) {
                                        foreach ($movieResult as $row) {
                                            echo "<tr>";
                                            echo "<th>";
                                            echo $row['title'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['description'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['releaseDate'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['rating'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['cast'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['producer'];
                                            echo "</th>";
                                            echo "<th>";
                                            echo $row['genres'];
                                            echo "</th>";
                                            echo "<th>";
                                            ?>
                                            <form method="post">
                                                <a href="pages/editmovie.php?id=<?php echo $row['id']?>">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                    <span class="text">Editar</span>
                                                </a>
                                            </form>
                                            <?php
                                            echo "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Alugueres</h6>
<!--                        <div class="dropdown no-arrow">-->
<!--                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"-->
<!--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>-->
<!--                            </a>-->
<!--                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"-->
<!--                                 aria-labelledby="dropdownMenuLink">-->
<!--                                <div class="dropdown-header">Opções:</div>-->
<!--                                <a class="dropdown-item" href="./pages/addmovie.php">Adicionar</a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Filme</th>
                                    <th>Utilizador</th>
                                    <th>Data</th>
                                    <th>Tempo restante</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($rentResult)) {
                                    foreach ($rentResult as $row) {
                                        $timeleft =
                                        $movieId = $row['movieId'];
                                        $userId = $row['userId'];
                                        $getSpecificMovie = "SELECT * FROM movie WHERE id='$movieId'";
                                        $specificMovieResult = $conn->query($getSpecificMovie);
                                        $getSpecificUser = "SELECT * FROM user WHERE id='$userId'";
                                        $specificUserResult = $conn->query($getSpecificUser);
                                        if (mysqli_num_rows($specificMovieResult) > 0) {
                                            if (mysqli_num_rows($specificUserResult) > 0) {
                                                foreach ($specificMovieResult as $movieRow) {
                                                    foreach ($specificUserResult as $userRow) {
                                                        echo "<tr>";
                                                        echo "<th>";
                                                        echo $movieRow['title'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                        echo $userRow['name'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                        echo $row['date'];
                                                        echo "</th>";
                                                        echo "<th>";
                                                        echo "1 semana";
                                                        echo "</th>";
                                                        echo "<th>";
                                                        ?>
                                                        <form method="post">
                                                            <a href="processes/removerent.php?id=<?php echo $row['id']?>">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <span class="text">Remover</span>
                                                            </a>
                                                        </form>
                                                        <?php
                                                        echo "</th>";
                                                        echo "</tr>";
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

            </div>
                <!-- /.container-fluid -->

            </div>
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
        header("Location: ./pages/login.php");
        exit();
    }
} else{

    header("Location: ./pages/login.php");
    exit();

}

?>