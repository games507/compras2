<?php
    include '../conexion.php'; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Valores --- INFORMACIÓN GENERAL ---------------
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $no_compra = $_POST['no_compra'] ?? '';
        $tipo_procedimiento = $_POST['tipo_procedimiento'] ?? '';
        $objeto_contractual = $_POST['objeto_contractual'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_publicacion = $_POST['fecha_publicacion'] ?? '';
        $fecha_presentacion = $_POST['fecha_presentacion'] ?? '';
        $fecha_apertura = $_POST['fecha_apertura'] ?? '';
        $lugar_presentacion = $_POST['lugar_presentacion'] ?? '';
        $termino_subsanacion = $_POST['termino_subsanacion'] ?? '';
        $precio_referencia = $_POST['precio_referencia'] ?? '';
        $estado = $_POST['estado'] ?? '';
    
        // Actualización segura de los datos
        $sql = "UPDATE wp_portalcompra SET 
                    no_compra = ?, 
                    tipo_procedimiento = ?, 
                    objeto_contractual = ?, 
                    descripcion = ?, 
                    fecha_publicacion = ?, 
                    fecha_presentacion = ?, 
                    fecha_apertura = ?, 
                    lugar_presentacion = ?, 
                    termino_subsanacion = ?, 
                    precio_referencia = ?, 
                    estado = ? 
                WHERE id = ?";
    
        // Preparar y ejecutar la sentencia
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $no_compra, $tipo_procedimiento, $objeto_contractual, $descripcion, $fecha_publicacion, $fecha_presentacion, $fecha_apertura, $lugar_presentacion, $termino_subsanacion, $precio_referencia, $estado, $id);
    
        if ($stmt->execute()) {
            $successMessage = "Registro actualizado con éxito.";
            header("Location: editar.php?id=$id");
            exit();
        } else {
            echo "<p>Error al actualizar el registro: " . htmlspecialchars($stmt->error) . "</p>";
        }
    }
?>