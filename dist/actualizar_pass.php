<?php
session_start(); 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'] ?? '';
    $new_pass = $_POST['old_pass'] ?? '';
    $seg_pass = $_POST['new_pass'] ?? '';

    $hashed_password = md5($new_pass);
    $sql_up = "UPDATE user_compra SET pass = ?, WHERE user = ?";
    $stmt_up = $conn->prepare($sql_up);
    $stmt_up->bind_param("s", $hashed_password, $user);

    if ($stmt_up->execute()) {
        $_SESSION['mensaje_ui'] = "Información general actualizada con éxito.";
    } else {
        $_SESSION['mensaje_ui'] = "Error al actualizar el registro: " . htmlspecialchars($stmt->error);
    }
}

?>