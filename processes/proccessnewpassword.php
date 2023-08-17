<?php
session_start();

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

if (isset($_POST['password']) & isset($_POST['rePassword'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $password = validate($_POST['password']);
    $rePassword = validate($_POST['rePassword']);

    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rePassword = filter_var($rePassword, FILTER_SANITIZE_STRING);

    $passwordFilter = '/^(?=.*[!@#$%^&*.-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,20}$/';

    if (empty($password)) {
        header("Location: ../pages/newpassword.php?error=Não preencheu a Password");
        exit();
    } else if (empty($rePassword)) {
        header("Location: ../pages/newpassword.php?error=Não preencheu a Repetição da Password");
        exit();
    } else {
        if ($password == $rePassword) {
            if (preg_match($passwordFilter, $password)) {
                $hashedPassword = md5($password);
                $sql = "UPDATE user SET password = '".$hashedPassword."' WHERE id = $id";
                $sql2 = "UPDATE user SET active = 1 WHERE id = $id";
                $result = $conn->query($sql);
                $result2 = $conn->query($sql2);

                if ($result) {
                    header("Location: ../pages/login.php?success=A password foi alterada com sucesso");
                    exit();
                } else {
                    header("Location: ../pages/newpassword.php?error=Algo de errado não está certo");
                    exit();
                }
            } else {
                header("Location: ../pages/newpassword.php?error=A Password tem de ter no mínimo uma letra maiúscula, 1 número e 1 caratere especial");
                exit();
            }
        } else {
            header("Location: ../pages/newpassword.php?error=As passwords não são iguais");
            exit();
        }
    }
}