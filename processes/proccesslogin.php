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

$numberOfWrongs = $_GET['count'];
$userId = 0;
$userEmail = $_POST['email'];
$getId = "SELECT id FROM user WHERE email = '$userEmail'";
$resultGetId = $conn->query($getId);
if (mysqli_num_rows($resultGetId) > 0) {
    $row = mysqli_fetch_assoc($resultGetId);
    $userId = $row['id'];
}


if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    //filtrações
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $passwordFilter = '/^(?=.*[!@#$%^&*.-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,20}$/';

    if (empty($email)) {
        header("Location: ../pages/login.php?error=Não preencheu o Email");
        exit();
    } else if (empty($password)) {
        header("Location: ../pages/login.php?error=Não preencheu a Password");
        exit();
    } else if (preg_match($passwordFilter, $password)) {
        $hashedPassword = md5($password);
        $sql = "SELECT * FROM user WHERE email='$email' AND password='$hashedPassword'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email && $row['password'] === $hashedPassword) {
                if ($row['active'] == 1) {
                    if ($row['role'] == 'User') {
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['email']  = $row['email'];
                        $_SESSION['age'] = $row['age'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['nTel'] = $row['nTel'];
                        $_SESSION['profilePic'] = $row['profilePic'];
                        if (!empty($_POST['remember_check'])) {
                            $remember_check = $_POST['remember_check'];

                            $key = 'Hipopotamo';
                            $encryptedText = openssl_encrypt($password, 'aes-256-cbc', $key);

                            setcookie('email', $email, time()+(86400*30), "/" );
                            setcookie('password', $encryptedText, time()+(86400*30), "/");
                            setcookie('userLogin', $remember_check, time()+(86400*30), "/");
                        } else {
                            setcookie('email', $email, time()+1);
                            setcookie('password', $hashedPassword,  time()+1);
                        }
                        header("Location: ../indexlogged.php");
                        exit();
                    } else {
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['email']  = $row['email'];
                        $_SESSION['age'] = $row['age'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['nTel'] = $row['nTel'];
                        if (!empty($_POST['remember_check'])) {
                            $remember_check = $_POST['remember_check'];

                            $key = 'Hipopotamo';
                            $encryptedText = openssl_encrypt($password, 'aes-256-cbc', $key);

                            setcookie('email', $email, time()+(86400*30), "/" );
                            setcookie('password', $encryptedText, time()+(86400*30), "/");
                            setcookie('userLogin', $remember_check, time()+(86400*30), "/");
                        } else {
                            setcookie('email', $email, time()+1);
                            setcookie('password', $hashedPassword,  time()+1);
                        }
                        header("Location: ../indexadmin.php");
                        exit();
                    }
                } else {
                    header("Location: ../pages/login.php?error=Conta foi desativada");
                    exit();
                }
            } else {
            }
        } else {
            while($numberOfWrongs < 4) {
                $numberOfWrongs++;
                if ($numberOfWrongs == 3) {
                    header("Location: ../pages/login.php?error=Email ou Password incorreto! Tem mais 2 tentativas até bloqueio da conta!&&count=$numberOfWrongs");
                    exit();
                } else if ($numberOfWrongs == 4) {
                    header("Location: ../pages/login.php?error=Email ou Password incorreto! Tem mais 1 tentativa até bloqueio da conta!&&count=$numberOfWrongs");
                    exit();
                } else {
                    header("Location: ../pages/login.php?error=Email ou Password incorreto&&count=$numberOfWrongs");
                    exit();
                }
            };
            $sql = "UPDATE user SET active = 0 WHERE id = '$userId'";
            $result = $conn->query($sql);
            if ($result) {
                header("Location: ../pages/login.php?error=A conta foi bloqueada! Contacte o administrador (carvalhomiguel286@gmail.com) para reaver a sua conta.&&count=$numberOfWrongs");
                exit();
            } else {
                header("Location: ../pages/login.php?error=Bloqueio de conta not successfull");
                exit();
            }
        }
    } else {
        while($numberOfWrongs < 4) {
            $numberOfWrongs++;
            if ($numberOfWrongs == 3) {
                header("Location: ../pages/login.php?error=Email ou Password incorreto! Tem mais 2 tentativas até bloqueio da conta!&&count=$numberOfWrongs");
                exit();
            } else if ($numberOfWrongs == 4) {
                header("Location: ../pages/login.php?error=Email ou Password incorreto! Tem mais 1 tentativa até bloqueio da conta!&&count=$numberOfWrongs");
                exit();
            } else {
                header("Location: ../pages/login.php?error=Email ou Password incorreto&&count=$numberOfWrongs");
                exit();
            }
        };
        $sql = "UPDATE user SET active = 0 WHERE id = '$userId'";
        $result = $conn->query($sql);
        if ($result) {
            header("Location: ../pages/login.php?error=A conta foi bloqueada! Contacte o administrador (carvalhomiguel286@gmail.com) para reaver a sua conta.&&count=$numberOfWrongs");
            exit();
        } else {
            header("Location: ../pages/login.php?error=Bloqueio de conta not successfull");
            exit();
        }
    }
}
