<?php
    include 'conexion.php';
    $user = $_POST['user'];

    $sql_rp = "UPDATE user_temp SET estado = 0 WHERE id = ?";
    $stmt_rp = $conn->prepare($sql_rp);
    $stmt_rp->bind_param("s", $user);
    if ($stmt_rp->execute()) {
        echo "Contraseña reiniciada.";
    } else {
        echo "No se pudo reiniciar la contraseña.";
    }
    $stmt_rp->close();
?>