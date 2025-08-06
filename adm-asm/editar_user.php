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
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $departamento = $_POST['departamento'] ?? '';
        $email = $_POST['email'] ?? '';
        $user = $_POST['user'] ?? '';
        $rol = $_POST['rol'] ?? '';
        $edit_date = date("Y-m-d H:i:s"); 

        $sql = "UPDATE user_compra SET nombre = ?, apellido = ?, departamento = ?, email = ?, user = ?, edit_date = ?, rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nombre, $apellido, $departamento, $email, $user, $edit_date, $rol, $id);
        if ($stmt->execute()) {
            $_SESSION['mensaje_adm'] = "Usuario actualizado con éxito.";
        } else {
            $_SESSION['mensaje_adm'] = "Error al actualizar el registro: " . htmlspecialchars($stmt->error);
        }
    header("Location: index.php");
    exit();
    }
?>