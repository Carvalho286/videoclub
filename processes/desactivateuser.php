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
$name = $_GET['name'];

$sql = "UPDATE user SET active = 0 WHERE id = $id";
$result = $conn->query($sql);

if ($result) {
    header("Location: ../indexadmin.php");
    exit();
} else {
    ?>
    <h1>Foi impossivel desativar o utilizador: <?php echo $name ?></h1>
    <a href="../indexadmin.php">Voltar</a>
    <?php
}
?>