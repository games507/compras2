<?php
session_start(); 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'] ?? '';
    $new_pass = $_POST['new_pass'] ?? '';
    $seg_pass = $_POST['seg_pass'] ?? '';

    $hashed_password = md5($new_pass);
    //echo $new_pass;
    //echo $hashed_password;
    $sql_up = "UPDATE user_compra SET pass = ? WHERE user = ?";
    $stmt_up = $conn->prepare($sql_up);
    $stmt_up->bind_param("ss", $hashed_password, $user);

    $sql_ut = "UPDATE user_temp SET estado = 1 WHERE user = ?";
    $stmt_ut = $conn->prepare($sql_ut);
    $stmt_ut->bind_param("s", $user);

    if ($stmt_up->execute()) {
        if ($stmt_ut->execute()) {
            $_SESSION['mensaje_log'] = "Contraseña actualizada.";
        } else {
            $_SESSION['mensaje_log'] = "Contraseña temporal no actualizada: " . htmlspecialchars($stmt_ut->error);
        }
    } else {
        $_SESSION['mensaje_log'] = "No se pudo actualizar la contraseña: " . htmlspecialchars($stmt_up->error);
    }
    //header("Location: login.php");
    //exit();
}

?>