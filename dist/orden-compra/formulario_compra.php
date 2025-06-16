<?php
// Luis Robles A. Desarrollador
// Municipio de San Miguelito
// Portal de Compra Noviembre 2024
// Creditos Anthony Santana Desarrollador
// Este archivo fue creado como parte del proyecto [Nombre del Proyecto]
// Supervisado por Dir. Joseph Arosemena

// Iniciar sesión para acceder al usuario logueado
session_start();
header('Content-Type: text/html; charset=utf-8');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redirige al login si no está autenticado
    exit();
}

// Usuario logueado
$usuario_registrado = $_SESSION['usuario'];

// Conexión a la base de datos
include '../conexion.php';


try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$pdo->exec("SET NAMES utf8mb4"); // Forzamos la codificación UTF-8 auct. 20_2_25
}catch (PDOException $e) {
    die("(catch)Error de conexión: " . $e->getMessage());
}

// Captura los datos enviados por el formulario
//$id = $_POST['id'] ?? null;
$no_compra = $_POST['no_compra'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$proveedor = $_POST['proveedor'] ?? null;
$monto = $_POST['monto'] ?? null;
$f_publicacion = $_POST['f_publicacion'] ?? null;
$pdf = $_POST['pdf'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Consulta SQL para insertar los datos en wp_portalcompra
        $sql = "INSERT INTO wp_ordencompra (
                    no_compra, descripcion, proveedor, monto, f_publicacion, pdf, usuario_registrado
                ) VALUES (
                    :no_compra, :descripcion, :proveedor, :monto, :f_publicacion, :pdf, :usuario_registrado
                )";
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con los parámetros
        $stmt->execute([
            ':no_compra' => $no_compra,
            ':descripcion' => $descripcion,
            ':proveedor' => $proveedor,
            ':monto' => $monto,
            ':f_publicacion' => $f_publicacion,
            ':pdf' => $pdf,
            ':usuario_registrado' => $usuario_registrado,
        ]);

        // Obtener el ID de la compra insertada
        $id_pcompra = $pdo->lastInsertId();

        // Redirigir al formulario de documentos con el ID de la compra
        header("Location: form/index.php?id_pcompra=$id_pcompra");
        exit();

    } catch (PDOException $e) {
        // Mostrar el error
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
?>
