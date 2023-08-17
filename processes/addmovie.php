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

session_start();
require '../PHPMailer-5.2-stable/PHPMailerAutoload.php';

if (isset($_POST['title']) && isset($_FILES['uploadImage']) && isset($_POST['description']) && isset($_POST['releaseDate']) && isset($_POST['rating']) && isset($_POST['cast']) && isset($_POST['producer']) && isset($_POST['genres'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $title = validate($_POST['title']);
    $description = validate($_POST['description']);
    $releaseDate = validate($_POST['releaseDate']);
    $rating = validate($_POST['rating']);
    $cast = validate($_POST['cast']);
    $producer = validate($_POST['producer']);
    $genres = validate($_POST['genres']);


    if (empty($title)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu o Titulo");
        exit();
    } else if (empty($description)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu a Descricao");
        exit();
    } else if (empty($releaseDate)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu a Data de Lancamento");
        exit();
    } else if (empty($rating)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu o Rating");
        exit();
    } else if (empty($cast)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu o Cast");
        exit();
    } else if (empty($producer)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu a Producao");
        exit();
    } else if (empty($genres)) {
        header("Location: ../pages/addmovie.php?error=Não preencheu os Generos");
        exit();
    } else {
        $imgName = $_FILES['uploadImage']['name'];
        $imgSize = $_FILES['uploadImage']['size'];
        $tmpName = $_FILES['uploadImage']['tmp_name'];
        $error = $_FILES['uploadImage']['error'];

        if ($error === 0) {
            $imgEx = pathinfo($imgName, PATHINFO_EXTENSION);
            $imgExLc = strtolower($imgEx);

            $allowedExs = array("jpg", "jpeg", "png");

            if (in_array($imgExLc, $allowedExs)) {
                $newImageName = uniqid("IMG-", true).'.'.$imgExLc;
                $imgUploadPath = './../moviesImages/'.$newImageName;
                move_uploaded_file($tmpName, $imgUploadPath);

                //Adicionar a base de dados
                $checkMovie = "SELECT * FROM movie WHERE title='$title'";
                $resultCheck = $conn->query($checkMovie);
                if (mysqli_num_rows($resultCheck) > 0) {
                    header("Location: ../pages/addmovie.php?error=Esse filme ja existe");
                    exit();
                } else {
                    $sql = "INSERT INTO movie(title, image, description, releaseDate, rating, cast, producer, genres, rented) VALUES('$title', '$newImageName', '$description', '$releaseDate', '$rating', '$cast', '$producer', '$genres', '0')";
                    $result = $conn->query($sql);

                    if ($result) {
                        header("Location: ../indexadmin.php");
                        exit();
                    } else {
                        header("Location: ../pages/addmovie.php?error=Algo de errado nao esta certo");
                        exit();
                    }
                }
            } else {
                header("Location: ../pages/addmovie.php?error=Essa extensao nao e permitida");
                exit();
            }
        } else {
            header("Location: ../pages/addmovie.php?error=Algum erro na imagem foi ocurrido");
            exit();
        }
    }


} else {
    header("Location: ../pages/addmovie.php?error=FDS");
    exit();
}
