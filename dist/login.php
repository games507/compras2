<?php
// Luis Robles A. Desarrollador
// Municipio de San Miguelito
// Portal de Compra Noviembre 2024
// Creditos Anthony Santana Desarrollador
// Supervisado por Dir. Joseph Arosemena
include 'conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_login = trim($_POST['user_login']);
    $user_pass = trim($_POST['user_pass']);

    if (!empty($user_login) && !empty($user_pass)) {
        $sql_temp = "SELECT * FROM user_temp WHERE user = ? AND estado = 0";
        $stmt_temp = $conn->prepare($sql_temp);
        $stmt_temp->bind_param("s", $user_login);
        $stmt_temp->execute();
        $pre_search = $stmt_temp->get_result();

        if ($pre_search->num_rows === 0) {
            $sql = "SELECT * FROM user_compra WHERE user = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $user_login);
                $stmt->execute();
                $search = $stmt->get_result();

                if ($search->num_rows === 1) {
                    $usuario = $search->fetch_assoc();
                    $hashed_password_input = md5($user_pass);
                    $result = mysqli_query($conn, "SELECT * FROM user_compra WHERE user = '$user_login' AND pass = '$hashed_password_input'");
                    if (mysqli_num_rows($result) > 0) {
                        session_start();
                        $_SESSION['user'] = $user_login;
                        $_SESSION['rol'] = $usuario['rol'];
                        $image = imagecreate(512, 512);
                        $text_color = imagecolorallocate($image, 0, 47, 108);
                        $background_color = imagecolorallocate($image, 255, 255, 255);
                        $font_path = __DIR__.'/arial.ttf';
                        $text = substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1);;
                        imagefill($image, 0, 0, $background_color);
                        imagettftext($image, 220, 0, 50, 350, $text_color, $font_path, $text );
                        $filename = "imagen-". $_SESSION['user'] .".png";
                        imagepng($image, "profiles/" . $filename);
                        if (isset($_SESSION['previous_page'])) {
                            header('Location: ' . $_SESSION['previous_page']);
                            exit();
                        }else{
                            header("Location: index.php");
                            exit;
                        }
                    } else {
                        $error_message = "Contraseña incorrecta.";
                    }
                } else {
                    $error_message = "Usuario no encontrado.";
                }
            } else {
                $error_message = "Error en la consulta.";
            }
        } else {
            echo("<script></script>");
        }
    } else {
        $error_message = "Por favor, complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <link rel="stylesheet" href="css\estilos-pc-asm.scss">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="login-page-pc">
<div class="login-box" style="border-radius: 30px;">
    <div class="card">
        <div class="card-body login-card-body" style="align-items: center; text-align: center !important; border-radius: 30px;">
            <img class="brand-image-pc" style="max-width: 200px;" src="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/Escudo-AlcaldiaSanMiguelito-RGB_Horizontal.png">
            <h3 class="login-box-msg">¡Hola! <b>Bienvenido</b></h3>
            <p class="login-box-msg">Inicia sesión para continuar</p>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="input-group mb-3">
                    <input type="text" name="user_login" class="form-control" placeholder="Nombre de usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="user_pass" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </div>
                </div>
            </form>
            
            <p class="mb-1 mt-3">
                <a href="http://localhost/compras2/dist/index.php"><i style="margin-right: 5px;" class="bi bi-arrow-left-circle-fill"></i>Volver al inicio</a>
            </p>
        </div>
    </div>
</div>

<!-- AdminLTE Scripts -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
