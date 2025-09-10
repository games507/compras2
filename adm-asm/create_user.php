<?php
session_start();
$logueado = false;
$_SESSION['previous_page'] = false;
if (!isset($_SESSION['user'])) {
    header("Location: ../dist/login.php");
    exit;
}else{
    $logueado = isset($_SESSION['user']);
}
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
include '../dist/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $email = $_POST['email'] ?? '';
    $user = $_POST['user'] ?? '';
    $temp_pass = $_POST['temp_pass'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $created_date = date("Y-m-d H:i:s");
    $created_user = $_SESSION['user'];

    $stmt_user = $conn->prepare("INSERT INTO user_compra (nombre, apellido, departamento, email, user, rol, created_date, created_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_user->bind_param('ssssssss', $nombre, $apellido, $departamento, $email, $user, $rol, $created_date, $created_user);

    $stmt_temp = $conn->prepare("INSERT INTO user_temp (user, universal_pass) VALUES (?, ?)");
    $stmt_temp->bind_param('ss', $user, $temp_pass);

    if ($stmt_user->execute()) {
        if ($stmt_temp->execute()) {
            $_SESSION['mensaje_adm'] = "Usuario creado con éxito.";
        } else {
            $_SESSION['mensaje_adm'] = "Usuario temporal no creado.";
        }
    } else {
        echo "Error al agregar usuario: " . $stmt_user->error;
    }
    header("Location: index.php");
    exit();
}
?>