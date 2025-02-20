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

$id = $_GET['id'];

if (isset($_POST['name']) && isset($_POST['age']) && isset($_POST['nTel']) && isset($_POST['address'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $name = validate($_POST['name']);
    $age = validate($_POST['age']);
    $nTel = validate($_POST['nTel']);
    $address = validate($_POST['address']);

    if (empty($name)) {
        header("Location: ../pages/edituser.php?error=Não pode deixar o Nome vazio");
        exit();
    } else if (empty($age)) {
        header("Location: ../pages/edituser.php?error=Não pode deixar a Idade vazia");
        exit();
    } else if (empty($nTel)) {
        header("Location: ../pages/edituser.php?error=Não pode deixar o Numero de Telemovel vazio");
        exit();
    } else if (empty($address)) {
        header("Location: ../pages/edituser.php?error=Não pode deixar a Morada vazia");
        exit();
    } else {
        $imgName = $_FILES['profilePic']['name'];
        $imgSize = $_FILES['profilePic']['size'];
        $tmpName = $_FILES['profilePic']['tmp_name'];
        $error = $_FILES['profilePic']['error'];

        if ($error === 0) {
            $imgEx = pathinfo($imgName, PATHINFO_EXTENSION);
            $imgExLc = strtolower($imgEx);

            $allowedExs = array("jpg", "jpeg", "png");

            if (in_array($imgExLc, $allowedExs)) {
                $newImageName = uniqid("IMG-", true).'.'.$imgExLc;
                $imgUploadPath = '../userImages/'.$newImageName;
                move_uploaded_file($tmpName, $imgUploadPath);

                $checkPhoneNumber = "SELECT * FROM user WHERE nTel = '$nTel' AND id !='$id'";
                $resultCheckPhoneNumber = $conn->query($checkPhoneNumber);

                if (mysqli_num_rows($resultCheckPhoneNumber) > 0) {
                    header("Location: ../pages/edituser.php?error=Esse numero de telemovel ja esta a ser usado por outro utilizador.");
                    exit();
                } else {
                    if (empty(isset($_FILES['profilePic']))) {
                        $sql = "UPDATE user SET name = '".$name."', age = '".$age."', nTel = '".$nTel."', address = '".$address."' WHERE id = '$id'";
                        $result = $conn->query($sql);

                        if ($result) {
                            header("Location: ../pages/profiel.php?success=Perfil editado com sucesso.");
                            exit();
                        } else {
                            header("Location: ../pages/edituser.php?error=Algo de errado nao esta certo.");
                            exit();
                        }
                    } else {
                        $sql1 = "UPDATE user SET name = '".$name."', age = '".$age."', nTel = '".$nTel."', address = '".$address."', profilePic = '".$newImageName."' WHERE id = '$id'";
                        $result1 = $conn->query($sql1);

                        if ($result1) {
                            header("Location: ../pages/profile.php?success=Perfil editado com sucesso.");
                            exit();
                        } else {
                            header("Location: ../pages/edituser.php?error=Algo de errado nao esta certo.");
                            exit();
                        }
                    }
                }
            }
        }
    }
} else {
    echo "lol";
}