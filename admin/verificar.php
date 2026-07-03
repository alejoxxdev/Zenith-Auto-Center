<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/login.php');
    exit();
}

if ($_SESSION['is_admin'] !== 1) {
    echo "<script>alert('Acceso denegado.'); window.location.href = '../index.php';</script>";
    exit();
}

?>