<?php
    include 'conexion.php';
    $id = $_POST['id'];

    // Eliminar fila de la base de datos
    $stmt = $conn->prepare("DELETE FROM user_compra WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar de la base de datos.";
    }
    $stmt->close();
?>