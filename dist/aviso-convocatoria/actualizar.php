<?php
    session_start(); // Inicia la sesión para poder acceder a $_SESSION
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
        $sql_ui = "UPDATE wp_portalcompra SET 
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
        $stmt_ui = $conn->prepare($sql_ui);
        $stmt_ui->bind_param("sssssssssssi", $no_compra, $tipo_procedimiento, $objeto_contractual, $descripcion, $fecha_publicacion, $fecha_presentacion, $fecha_apertura, $lugar_presentacion, $termino_subsanacion, $precio_referencia, $estado, $id);
        
        if ($stmt_ui->execute()) {
            $_SESSION['mensaje_ui'] = "Información general actualizada con éxito.";
        } else {
            $_SESSION['mensaje_ui'] = "Error al actualizar el registro: " . htmlspecialchars($stmt->error);
        }


        if (isset($_POST['items'])) {
            // Asegurarse de que la carpeta de subida existe
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true); // Crea la carpeta si no existe
            }
            // Preparar la consulta SQL
            $stmt_uf = $conn->prepare("INSERT INTO wp_docompra (id_pcompra, nombre, date, pdf) VALUES (?, ?, ?, ?)");
            foreach ($_POST['items'] as $index => $item) {

                // Verificar que el formulario tiene valores válidos
                if (!empty($item['nombre']) && !empty($item['date']) && !empty($_FILES['pdf']['name'][$index])) {
                    // Subir el archivo PDF
                    $pdfName = basename($_FILES['pdf']['name'][$index]); // Obtener el nombre del archivo
                    $targetFilePath = $targetDir . $pdfName; // Ruta completa del archivo
                    // Verificar si el archivo se movió correctamente
                    if (move_uploaded_file($_FILES['pdf']['tmp_name'][$index], $targetFilePath)) {
                        echo "Archivo subido con éxito: " . $pdfName . "<br>"; // Mostrar el nombre del archivo subido
                        // Ahora insertamos el registro en la base de datos con la ruta del archivo
                        $stmt_uf->bind_param('ssss', $id, $item['nombre'], $item['date'], $pdfName);
                        // Ejecutar la consulta y verificar si fue exitosa
                        if ($stmt_uf->execute()) {
                            echo "Documento " . $item['nombre'] . " guardado correctamente.<br>";
                        } else {
                            echo "Error al guardar el documento " . $item['nombre'] . ".<br>";
                        }
                    } else {
                        echo "Error al mover el archivo: " . $pdfName . "<br>";
                    }
                } else {
                    echo "Por favor complete todos los campos para el documento " . $item['nombre'] . ".<br>";
                }
            }
        }


        if (isset($_POST['2items'])) {
            // Preparar la consulta SQL
            $stmt_up = $conn->prepare("INSERT INTO wp_proponentes (id_pcompra, proponente, oferta, hora, aprobado) VALUES (?, ?, ?, ?, ?)");
            foreach ($_POST['2items'] as $index => $item2) {
                // Verificar que el formulario tiene valores válidos
                if (!empty($item2['proponente']) && !empty($item2['oferta'])) {
                    $stmt_up->bind_param('sssss', $id, $item2['proponente'], $item2['oferta'], $item2['hora'], $item2['aprobado']);
                    // Ejecutar la consulta y verificar si fue exitosa
                    if ($stmt_up->execute()) {
                        echo "Proponente " . $item2['proponente'] . " guardado correctamente.<br>";
                    } else {
                        echo "Error al guardar el documento " . $item2['nombre'] . ".<br>";
                    }
                } else {
                    echo "Por favor complete todos los campos para el proponentes" . ".<br>";
                }
            }
            // Mostrar mensaje de éxito al finalizar
            echo '<div class="alert alert-success" role="alert">¡Los proponentes se han agregado correctamente!</div>';
        }


        header("Location: editar.php?id=". $id);
        //header("Location: javascript:history.go(-1)");
        exit();
    }
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.getElementById('popupMessage');
            if (popup.textContent.trim() !== "") {
                popup.classList.add('show');
                setTimeout(() => {
                    popup.classList.remove('show');
                    history.go(-2);
                }, 2000); // Ocultar después de 30 segundos
            }
        });
    </script>