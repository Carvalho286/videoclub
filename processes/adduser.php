<?php

session_start();
require '../PHPMailer-5.2-stable/PHPMailerAutoload.php';

//connexão à BD;
$sname= "localhost";
$unmae= "root";
$password= "root";

$db_name= "videoclub";

$conn= mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection Failed";

}

$mail = new PHPMailer;

$mail->SMTPDebug = 3;
$mail->Debugoutput = 'html';
$mail->setLanguage('pt');
$mail->isSMTP();
$mail->Host = 'smtp.sapo.pt';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'carvalhomiguel286@sapo.pt';
$mail->Password = 'Scan2gogo';
$mail->Port = 587;

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['nTel']) && isset($_POST['address'])) {

    function validate($data){
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

    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $nTel = filter_var($nTel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nTel = filter_var($nTel, FILTER_SANITIZE_STRING);
    $age = filter_var($age, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $age = filter_var($age, FILTER_SANITIZE_STRING);

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
    } else {

        $checkEmail = "SELECT * FROM user WHERE email = '$email'";
        $checkEmailResult = $conn->query($checkEmail);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            header("../pages/adduser.php?error=Email já utilizado");
            return;
        } else {

            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
            $password = substr(str_shuffle($chars), 8,13);

            $hashedPassword = md5($password);

            $insertSQL = "INSERT INTO user(name, age, email, password, nTel, address, role, active) VALUES('$name', '$age', '$email', '$hashedPassword', '$nTel', '$address', 'User', 1)";
            $insertResult = $conn->query($insertSQL);

            if ($insertResult) {
                $link = 'http://localhost:8888/PHPstorm/websiteSAW/pages/login.php';
                $mail->setFrom('carvalhomiguel286@sapo.pt');
                $mail->addReplyTo('mcarvalhomiguel286@sapo.pt');

                $mail->addAddress($email, 'Utilizador');
                $mail->isHTML(true);
                $mail->Subject = 'Criação de conta';
                $mail->Body    = 'A pedido do utilizador, enviamos as suas novas credenciais da sua conta! (Para sua segurança, recomendamos ir ao seu perfil alterar a sua password) <br /> <b>Email:</b> '.$email.'<br /> <b>Password:</b> '.$password;
                $mail->altBody = '';

                if (!$mail->send()) {
                    echo 'Não foi possível enviar a mensagem.<br>';
                    echo 'Erro: ' . $mail->ErrorInfo;
                } else {
                    header("../pages/adduser.php?error=Conta e Email enviado com sucesso!");
                    return;
                }
            }
        }

    }

} else {
    header("../indexadmin.php");
    return;
}