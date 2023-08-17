<?php
require '../PHPMailer-5.2-stable/PHPMailerAutoload.php';

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

if (isset($_POST['email'])) {
    function validate($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    $email = validate($_POST['email']);

    //filtrações
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        header("Location: ../pages/forgot-password.php?error=Não preencheu o Email");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
        } else {

        }
        $id = $row['id'];

        $link = 'http://localhost:8888/PHPstorm/websiteSAW/pages/newPassword.php?id=';

        if ($result) {
            $mail->setFrom('carvalhomiguel286@sapo.pt');
            $mail->addReplyTo('mcarvalhomiguel286@sapo.pt');

            $mail->addAddress($email, 'Utilizador');
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacao da Password';
            $mail->Body    = 'Para puder recuperar a sua Password basta seguir o link!<br>http://localhost:8888/PHPstorm/websiteSAW/pages/newPassword.php?id='.$id;
            $mail->altBody = '';

            if (!$mail->send()) {
                //header("Location: ../pages/forgot-password.php?error=Não foi possivel enviar o Email");
                //exit();
                echo 'Não foi possível enviar a mensagem.<br>';
                echo 'Erro: ' . $mail->ErrorInfo;
            } else {
                header("Location: ../pages/forgot-password.php?success=Email enviado com sucesso");
                exit();
            }
        } else {
            header("Location: ../pages/forgot-password.php?error=Esse Email não está registado");
            exit();
        }
    }
}
