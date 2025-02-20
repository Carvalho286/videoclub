<?php
session_start();

//connexão à BD;
$sname= "localhost";
$unmae= "root";
$password= "root";

$db_name= "videoclub";

$conn= mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection Failed";

}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['nTel']) && isset($_POST['age']) && isset($_POST['password']) && isset($_POST['rePassword'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $address = validate($_POST['address']);
    $nTel = validate($_POST['nTel']);
    $age = validate($_POST['age']);
    $password = validate($_POST['password']);
    $rePassword = validate($_POST['rePassword']);

    //filtraçoes
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $nTel = filter_var($nTel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nTel = filter_var($nTel, FILTER_SANITIZE_STRING);
    $age = filter_var($age, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $age = filter_var($age, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rePassword = filter_var($rePassword, FILTER_SANITIZE_STRING);

    $passwordFilter = '/^(?=.*[!@#$%^&*.-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,20}$/';
    $onlyNumbersNTel = '/^(?=(255|96|92|91|93))[0-9]{9}$/';
    $onlyTextMin3 = '/^(?=.*[A-Z])(?=.*[a-z]).{3,20}$/';


    if (empty($name)) {
        header("Location: ../pages/register.php?error=Não preencheu o Nome");
        exit();
    } else if (empty($email)) {
        header("Location: ../pages/register.php?error=Não preencheu o Email");
        exit();
    } else if (empty($address)) {
        header("Location: ../pages/register.php?error=Não preencheu a Morada");
        exit();
    } else if (empty($nTel)) {
        header("Location: ../pages/register.php?error=Não preencheu o Numero de Telemóvel");
        exit();
    } else if (empty($age)) {
        header("Location: ../pages/register.php?error=Não preencheu a Idade");
        exit();
    } else if (empty($password)) {
        header("Location: ../pages/register.php?error=Não preencheu a Password");
        exit();
    } else if (empty($rePassword)) {
        header("Location: ../pages/register.php?error=Não preencheu a Repetição da Password");
        exit();
    } else {
        if (preg_match($onlyTextMin3, $name)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (preg_match($onlyNumbersNTel, $nTel)) {
                    if ($password == $rePassword) {
                        if (preg_match($passwordFilter, $password)) {
                            $queryCheckEmail = "SELECT * FROM user WHERE email='$email'";
                            $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);
                            $queryCheckPhoneNumber = "SELECT * FROM user WHERE nTel='$nTel'";
                            $resultCheckPhoneNumber = mysqli_query($conn, $queryCheckPhoneNumber);
                            if (mysqli_num_rows($resultCheckEmail) > 0) {
                                header("Location: ../pages/register.php?error=Email já em uso");
                                exit();
                            } else if (mysqli_num_rows($resultCheckPhoneNumber) > 0){
                                header("Location: ../pages/register.php?error=Número de Telemóvel já em uso");
                                exit();
                            } else {
                                $hashedPassword = md5($password);
                                $sql = "INSERT INTO user(name, age, email, password, nTel, address, role, active) VALUES('$name', '$age', '$email', '$hashedPassword', '$nTel', '$address', 'User', 1)";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    header("Location: ../pages/login.php?success=A tua conta foi criada com sucesso");
                                    exit();
                                } else {
                                    header("Location: ../pages/register.php?error=Erro desconhecido ocorrido");
                                    exit();
                                }
                            }
                        } else {
                            header("Location: ../pages/register.php?error=A Password tem de ter no mínimo uma letra maiúscula, 1 número e 1 caratere especial");
                            exit();
                        }
                    } else {
                        header("Location: ../pages/register.php?error=As Passwords não são iguais");
                        exit();
                    }
                } else {
                    header("Location: ../pages/register.php?error=O Número de Telemóvel não existe em Portugal");
                    exit();
                }
            } else {
                header("Location: ../pages/register.php?error=O Email introduzido não é um email");
                exit();
            }
        } else {
            header("Location: ../pages/register.php?error=O Nome tem de ter no minimo 3 carateres");
            exit();
        }
    }
} else {
    header("Location: ../pages/register.php");
    exit();
}