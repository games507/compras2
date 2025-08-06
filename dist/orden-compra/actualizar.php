<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

include '../conexion.php'; // Incluir el archivo de conexión
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valores del formulario
    $id = $_POST['id'] ?? '';
    $no_compra = $_POST['no_compra'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $proveedor = $_POST['proveedor'] ?? '';
    $monto = $_POST['monto'] ?? '';
    $f_publicacion = $_POST['f_publicacion'] ?? '';
    $current_doc = $_POST['current_doc'];
    $pdf = $_POST['pdf'] ?? '';

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Crea la carpeta si no existe
    }
    
    if (!isset($_FILES['pdf']['name'])) {
        $sql = "UPDATE wp_ordencompra SET no_compra = ?, descripcion = ?, proveedor = ?, monto = ?, f_publicacion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $no_compra, $descripcion, $proveedor, $monto, $f_publicacion, $id);
    } else {
        $sql = "UPDATE wp_ordencompra SET no_compra = ?, descripcion = ?, proveedor = ?, monto = ?, f_publicacion = ?, pdf = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $pdfName = basename($_FILES['pdf']['name']); // Obtener el nombre del archivo
        $targetFilePath = $targetDir . $pdfName; // Ruta completa del archivo
        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFilePath)) {
            echo "<script>alert('Archivo subido exitosamente');</script>";
        } else {
            echo "<script>alert('Error al mover el archivo');</script>";
        }
        $stmt->bind_param("ssssssi", $no_compra, $descripcion, $proveedor, $monto, $f_publicacion, $pdfName, $id);
        unlink("uploads/" . $current_doc);
    }
    if ($stmt->execute()) {
        $successMessage = "Registro actualizado con éxito.";
    } else {
        echo "<p>Error al actualizar el registro: " . htmlspecialchars($stmt->error) . "</p>";
    }
    header("Location: editar.php?id=". $id);
    exit();
}
?>