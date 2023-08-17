<?php

session_unset();
session_destroy();
setcookie('PHPSESSID', '0', time()+1);

header("Location: ../pages/login.php");