<?php

// Iniciar sesión para acceder al usuario logueado
session_start();
header('Content-Type: text/html; charset=utf-8');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php'); // Redirige al login si no está autenticado
    exit();
}

// Usuario logueado
$usuario_registrado = $_SESSION['usuario'];

// Conexión a la base de datos
include '../conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos enviados por el formulario
    $no_compra = $_POST['no_compra'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $proveedor = $_POST['proveedor'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $f_publicacion = $_POST['f_publicacion'] ?? null;
    $pdf = $_POST['pdf'] ?? null;

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Crea la carpeta si no existe
    }

    // Consulta SQL para insertar los datos en wp_portalcompra
    $stmt = $conn->prepare("INSERT INTO orden_compra (no_compra, descripcion, proveedor, monto, f_publicacion, pdf) VALUES (?, ?, ?, ?, ?, ?)");
    
    $pdfName = basename($_FILES['pdf']['name']); // Obtener el nombre del archivo
    $targetFilePath = $targetDir . $pdfName; // Ruta completa del archivo
    move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFilePath);

    // Ahora insertamos el registro en la base de datos con la ruta del archivo
    $stmt->bind_param('ssss', $no_compra, $descripcion, $proveedor, $monto, $f_publicacion, $pdfName);
    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo "Documento " . $item['nombre'] . " guardado correctamente.<br>";
    } else {
        echo "Error al guardar el documento " . $item['nombre'] . ".<br>";
    }

    // Redirigir al formulario de documentos con el ID de la compra
    header("Location: index.php");
    exit();
}
?>
