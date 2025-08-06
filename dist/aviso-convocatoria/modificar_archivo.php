<?php
    session_start(); // Inicia la sesión para poder acceder a $_SESSION
    include '../conexion.php'; 
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $id_pcompra = $_POST['id_pcompra'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $date = $_POST['date'] ?? '';
       
        $sql_uf = "UPDATE wp_docompra SET nombre = ?, date = ? WHERE id = ?";
        $stmt_uf = $conn->prepare($sql_uf);
       
        if ($stmt_uf === false) {
        die("Error al preparar la consulta: " . $conn->error);
        }
       
        $stmt_uf->bind_param("ssi", $nombre, $date, $id);
  
        if ($stmt_uf->execute()) {
            $_SESSION['mensaje_uf'] = "Archivo actualizado con éxito.";
        } else {
            $_SESSION['mensaje_uf'] = "Error al actualizar el registro: " . htmlspecialchars($stmt->error);
        }
        header("Location: editar.php?id=". $id_pcompra);
        exit();
    }
?>