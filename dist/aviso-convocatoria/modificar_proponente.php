<?php
    session_start(); // Inicia la sesión para poder acceder a $_SESSION
    include '../conexion.php'; 
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $id_pcompra = $_POST['id_pcompra'] ?? '';
        $proponente = $_POST['proponente'] ?? '';
        $oferta = $_POST['oferta'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $aprobado = $_POST['aprobado'] ?? '';

        $sql = "SELECT * FROM wp_proponentes WHERE id_pcompra = ? AND aprobado = 'Si'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_pcompra);
        $stmt->execute();
        $verify = $stmt->get_result();

        if ($verify->num_rows > 0 and $aprobado == 'Si') {
            $_SESSION['mensaje_up'] = "Registro no actualizado. Ya existe una empresa adjudicada.";
        } else {
            $sql_up = "UPDATE wp_proponentes SET proponente = ?, oferta = ?, hora = ?, aprobado = ? WHERE id = ?";
            $stmt_up = $conn->prepare($sql_up);
        
            if ($stmt_up === false) {
            die("Error al preparar la consulta: " . $conn->error);
            }
            $stmt_up->bind_param("ssssi", $proponente, $oferta, $hora, $aprobado, $id);
            if ($stmt_up->execute()) {
                $_SESSION['mensaje_up'] = "Proponente actualizado con éxito.";
            } else {
                $_SESSION['mensaje_up'] = "Error al actualizar el registro: " . htmlspecialchars($stmt->error);
            }
        }
        header("Location: editar.php?id=". $id_pcompra);
        exit();
    }
?>
