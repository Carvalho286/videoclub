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

$movieId = $_GET['id'];

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
        header("Location: ../pages/editmovie.php?error=Não preencheu o Titulo&&id=$movieId");
        exit();
    } else if (empty($description)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu a Descricao&&id=$movieId");
        exit();
    } else if (empty($releaseDate)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu a Data de Lancamento&&id=$movieId");
        exit();
    } else if (empty($rating)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu o Rating&&id=$movieId");
        exit();
    } else if (empty($cast)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu o Cast&&id=$movieId");
        exit();
    } else if (empty($producer)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu a Producao&&id=$movieId");
        exit();
    } else if (empty($genres)) {
        header("Location: ../pages/editmovie.php?error=Não preencheu os Generos&&id=$movieId");
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

                $sql = "UPDATE `movie` SET `title`='$title',`image`='$newImageName',`description`='$description',`releaseDate`='$releaseDate',`rating`='$rating',`cast`='$cast',`producer`='$producer',`genres`='$genres' WHERE id = '$movieId'";
                $result = $conn->query($sql);

                if ($result) {
                    header("Location: ../indexadmin.php");
                    exit();
                } else {
                    header("Location: ../pages/editmovie.php?error=Algo de errado nao esta certo&&id=$movieId");
                    exit();
                }
            } else {
                header("Location: ../pages/editmovie.php?error=Essa extensao nao e permitida&&id=$movieId");
                exit();
            }
        } else {
            header("Location: ../pages/editmovie.php?error=Algum erro na imagem foi ocurrido&&id=$movieId");
            exit();
        }
    }


} else {
    header("Location: ../pages/editmovie.php?error=FDS&&id=<?=$movieId?>");
    exit();
}
