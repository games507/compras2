<?php
// Luis Robles A. Desarrollador
// Municipio de San Miguelito
// Portal de Compra Noviembre 2024
// Creditos Anthony Santana Desarrollador
// Este archivo fue creado como parte del proyecto [Nombre del Proyecto]
// Supervisado por Dir. Joseph Arosemena
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

include '../conexion.php'; // Incluir el archivo de conexión
$successMessage = "";

// Obtener el ID del registro a editar
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consultar el registro actual para rellenar el formulario
$query = "SELECT * FROM wp_ordencompra WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
$current_doc = $record['pdf'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro | <?php echo htmlspecialchars($record['no_compra']); ?></title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <!-- CSS de AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Portal de Compras | Alcaldía de San Miguelito">
    <meta name="author" content="Alcaldía de San Miguelito">
    <meta name="description" content="Portal de Compras de la Alcaldía de San Miguelito. Creado con el objetivo de ser transparente con nuestros vecinos y brindar información inmediata a nuestros proveedores.">
    <meta name="keywords" content="portal de compras, alcaldia de san miguelito, municipio de san miguelito"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="..\css\estilos-pc-asm.scss">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        background-color: #002d69;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px; /* Espaciado para pantallas pequeñas */
    }
    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: black;
        text-align: left;
    }

    .button {
        background-color: #002d69;
        color: white;
        text-decoration: none;
    }
    .button:hover {
        background-color: #d32f2f;
        transform: scale(1.05);
    }
    .popup-message {
        display: none;
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #009639;
        color: white;
        padding: 15px 30px;
        border-radius: 4px;
        font-size: 16px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: opacity 0.5s ease;
        z-index: 1000;
    }
    .popup-message.show {
        display: block;
        opacity: 1;
    }
</style>


</head>
<body>
    <div class="content" style="width: 1000px;">
        <div class="container-fluid">
            <div class="card card-primary">
                <div style="padding-top: 40px; text-align: center;"><h2>Editar Registro</h2></div>
                <form method="POST" action="actualizar.php" class="frm-edit-pc" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                        <input type="hidden" name="current_doc" value="<?php echo htmlspecialchars($current_doc); ?>">
                        <div class="form-group">
                            <label class="req">No Compra:</label>
                            <input class="form-control" type="text" name="no_compra" value="<?php echo htmlspecialchars($record['no_compra']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="req">Descripción:</label>
                            <textarea class="form-control" type="text" name="descripcion" required><?php echo htmlspecialchars($record['descripcion']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="req">Proveedor:</label>
                            <input class="form-control" type="text" name="proveedor" value="<?php echo htmlspecialchars($record['proveedor']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="req">Monto:</label>
                            <input type="number" step="0.01" min="1" max="10000" class="form-control" oninput="limitDecimals(this)" id="monto" name="monto" value="<?php echo htmlspecialchars($record['monto']); ?>" required>
                            <script>
                                function limitDecimals(input) {
                                    var value = parseFloat(input.value);
                                    if (!isNaN(value)) {
                                        input.value = value.toFixed(2);
                                    }
                                }
                            </script>
                        </div>

                        <div class="form-group">
                            <label class="req">Fecha de publicación:</label>
                            <input class="form-control" type="datetime-local" name="f_publicacion" value="<?php echo htmlspecialchars($record['f_publicacion']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="req">PDF:</label>
                            <b><a href="uploads/<?php echo urlencode($record['pdf']); ?>" target="_blank"><i style="color: #00A9E0; width:20px; height: 20px;" class="fa fa-file-pdf-o"></i>Archivo existente</a></b> <br>
                            <p>Si agrega un archivo en el siguiente campo, reemplazará el archivo existente.</p>
                            <input type="file" class="form-control" id="pdf" name="pdf">
                        </div>
                    </div>
                    <div style="padding-top: 20px; padding-bottom: 20px;;" class="card-footer">
                        <button style="color: white; background-color: #009639" type="submit" class="btn"><i class="fas fa-save"></i> Actualizar Orden de Compra</button>
                        <a style="color: white; background-color: #D50032" onClick="javascript:history.go(-1)" class="btn"><i class="fas fa-arrow-left"></i> Cancelar</a>
                    </div>
                </form>
                <div id="popupMessage" class="popup-message">
                    <?php echo $successMessage; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.getElementById('popupMessage');
            if (popup.textContent.trim() !== "") {
                popup.classList.add('show');
                setTimeout(() => {
                    popup.classList.remove('show');
                    //history.go(-2);
                }, 2000); // Ocultar después de 30 segundos
            }
        });
    </script>
</body>
</html>
