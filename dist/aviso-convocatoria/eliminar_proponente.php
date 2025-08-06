<?php
    include '../conexion.php';
    $id = $_POST['id'];

    // Eliminar fila de la base de datos
    $stmt = $conn->prepare("DELETE FROM wp_proponentes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Proponente eliminado correctamente.";
    } else {
        echo "Error al eliminar de la base de datos.";
    }
    $stmt->close();
?>