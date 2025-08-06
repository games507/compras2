<?php
    include '../conexion.php';
    $archivo = $_POST['archivo']; // Evita path traversal
    $ruta = 'uploads/' . $archivo;
    $id = $_POST['id'];
    
    if (file_exists($ruta) && is_writable($ruta)) {
        if (unlink($ruta)) {
            // Eliminar fila de la base de datos
            $stmt = $conn->prepare("DELETE FROM wp_docompra WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "Archivo y registro eliminados correctamente.";
            } else {
                echo "Archivo eliminado, pero error al eliminar de la base de datos.";
            }
            $stmt->close();
        } else {
        echo "No se pudo eliminar el archivo del servidor.";
        }
    } else {
        echo "El archivo no existe o no tiene permisos.";
    }  
?>
