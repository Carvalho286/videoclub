<?php

//connexão à BD;
$sname= "localhost";
$unmae= "root";
$password= "localhostMiguel";

$db_name= "videoclub";

$conn= mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection Failed";

}

$id = $_GET['id'];

$getRentInfoSQL = "SELECT * FROM aluguer WHERE id = '$id'";
$getRentInfoResult = $conn->query($getRentInfoSQL);

if (mysqli_num_rows($getRentInfoResult) > 0) {
    foreach ($getRentInfoResult as $row) {
        $movieId = $row['movieId'];
        $userId = $row['userId'];

        $setRentedOnMovieSQL = "UPDATE movie SET rented='0' WHERE id='$movieId'";
        $setRentedOnMovieResult = $conn->query($setRentedOnMovieSQL);

        $setUnactiveOnRentSQL = "UPDATE aluguer SET active='1' WHERE id='$id'";
        $setUnactiveOnRentResult = $conn->query($setUnactiveOnRentSQL);

        if ($setRentedOnMovieSQL && $setUnactiveOnRentResult) {
            header("Location: ../pages/alugueres.php");
            exit();
        } else {
            echo "algo de errado não está certo";
        }
    }
}