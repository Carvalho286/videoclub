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

$movieId = $_GET['movieId'];
$userId = $_GET['userId'];

$checkIfMovieIsAvailable = "SELECT * FROM movie WHERE id='$movieId' AND rented='0'";
$result1 = $conn->query($checkIfMovieIsAvailable);

if (mysqli_num_rows($result1) > 0) {

    $rentMovie = "UPDATE movie SET rented='1' WHERE id='$movieId'";
    $result2 = $conn->query($rentMovie);

    if ($result2) {
        $saveRent ="INSERT INTO `aluguer`(`movieId`, `userId`,`active`) VALUES('$movieId','$userId','0');";
        $result3 = $conn->query($saveRent);
        if ($result3) {
            header("Location: ../pages/moviedetails.php?id=".$movieId."&success=Filme alugado com sucesso.");
            exit();
        } else {
            header("Location: ../pages/moviedetails.php?id=".$movieId."&error=Algo de errado não está certo com o aluguer. Por favor contacte um administrador.");
            exit();
        }
    } else {
        header("Location: ../pages/moviedetails.php?id=".$movieId."&error=Algo de errado não está certo com o aluguer. Por favor contacte um administrador.");
        exit();
    }

} else {
    header("Location: ../pages/moviedetails.php?id=".$movieId."&error=Filme não está disponivel para aluguer, de momento.");
    exit();
}


