<?php
// Luis Robles A. Desarrollador
// Municipio de San Miguelito
// Portal de Compra Noviembre 2024
// Creditos Anthony Santana Desarrollador
// Este archivo fue creado como parte del proyecto [Nombre del Proyecto]
// Supervisado por Dir. Joseph Arosemena
session_start();
//Definimos la sesión como FALSE para validar elementos propios de la sesión activa
$logueado = false;
$_SESSION['previous_page'] = false;
// Verifica si el usuario está logueado
$logueado = isset($_SESSION['user']);
$show_submenu = isset($_SESSION['show_submenu']);
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
include 'conexion.php'; // Incluir el archivo de conexión
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Datos de la pestaña del navegador-->
    <title>Portal de Compras | Alcaldía de San Miguelito</title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Portal de Compras | Alcaldía de San Miguelito">
    <meta name="author" content="Alcaldía de San Miguelito">
    <meta name="description" content="Portal de Compras de la Alcaldía de San Miguelito. Creado con el objetivo de ser transparente con nuestros vecinos y brindar información inmediata a nuestros proveedores.">
    <meta name="keywords" content="portal de compras, alcaldia de san miguelito, municipio de san miguelito"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="css\adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="css\estilos-pc-asm.scss">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <style>
        /* Fondo de la barra lateral*/
        .main-sidebar {
            background-color: #002F6C !important;
        }
        /* Cambiar las letras de los enlaces de la barra lateral a blanco */
        .main-sidebar .nav-link {
            color: white !important;
            border-radius: 10px;
        }
        /* Cambiar el color de los íconos a blanco */
        .main-sidebar .nav-icon {
            color: white !important;
        }
        /* Cambiar el color de los íconos cuando se pasa el mouse */
        .active .main-sidebar .nav-link:hover .nav-icon {
            background-color: #001f4d !important; /* Puedes cambiar el fondo en hover si lo deseas */
            color: #00A9E0 !important;  /* Cambiar el color del texto al pasar el mouse */
            border-radius: 10px;
        }
        /* Cambiar el color de los enlaces cuando se pasa el mouse */
        .main-sidebar .nav-link:hover {
            background-color: #001f4d !important; /* Puedes cambiar el fondo en hover si lo deseas */
            color: #00A9E0 !important;  /* Cambiar el color del texto al pasar el mouse */
            border-radius: 10px;
        }
        .text-bg-primary {
            background-color: #002F6C !important;
        }
        .text-bg-success{
            background-color: #002F6C !important;
        }
        .text-bg-warning{
            background-color: #002F6C !important;
        }
        .text-bg-danger{
            background-color: #002F6C !important;
        }
        .text-bg-info{
            background-color: #002F6C !important;
        }
        .text-bg-secondary{
            background-color: #002F6C !important; 
        }  
        /* Caja 'danger' con fondo #002d69 */
        .small-box.text-bg-danger {
            background-color: #002F6C !important; /* Fondo azul oscuro */
            color: white; /* Texto blanco */
        }

        /* Caja 'cancelado' con fondo transparente, borde blanco y letra blanca */
        .small-box.text-bg-secondary {
            background-color: transparent !important; /* Fondo transparente */
            border: 2px solid white !important; /* Borde blanco */
            color: white !important; /* Texto blanco */
        }

        /* Caja 'cancelar' y 'desierta' con fondo transparente y borde blanco */
        .small-box.custom-bg {
            background-color: transparent !important; /* Fondo transparente */
            border: 2px solid white !important; /* Borde blanco */
            color: white !important; /* Texto blanco */
        }
        .small-box.text-bg-danger {
        background-color: #002F6C !important;
        color: white;
        }
        .small-box.text-bg-secondary .inner h3,
        .small-box.text-bg-secondary .inner p {
            color: #002d69 !important;
        }

        .small-box.text-bg-secondary {
            background-color: transparent !important;
            border: 2px solid white !important;
            color: white !important;
        }
        .small-box .custom-bg {
            background-color: transparent !important;
            border: 1px solid white !important;
            color: white !important;
            margin-bottom: 0px !important;
        }

        .small-box path {
            color: white !important;
        }

        .small-box:hover path {
            color: #00A9E0 !important;
        }

        .small-box-footer:hover{
            background-color: #00A9E0 !important;
            border-bottom-right-radius:  0.375rem;
            border-bottom-left-radius:  0.375rem;
        }

        .last-box{
            padding-top: 3px !important;
            padding-bottom: 3px !important;
        }
    </style>
    
    <?php include 'menu.php';?>
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <h3 style="padding-top: 12px !important; padding-left: 12px !important;" class="mb-0"><b>Aviso de Convocatoria</b></h3>
                        <p style="padding-left: 12px !important; color: #808080; margin-bottom: 10px !important;" class="mb-0">Compras mayores a B./10,000.00 y menores a B./50,000.00</p>
                    </div>
                    <?php        
                    try {
                        // Consulta para contar los registros de la columna 'no_compra'
                        $query = "SELECT COUNT(no_compra) AS total FROM wp_portalcompra";
                        $stmt = $conn->query($query);
                    
                        // Obtener el resultado
                        $result = $stmt->fetch_assoc()['total'];
                        if ($result) {
                            $total_no_compra = $result; // Total de registros
                        } else {
                            $total_no_compra = 0; // Si no hay registros, devuelve 0
                        }
                    } catch (PDOException $e) {
                        // Manejo de errores
                        echo "Error en la consulta: " . $e->getMessage();
                        $total_no_compra = 0; // Valor predeterminado en caso de error
                    }
                    ?>
            
                    <div class="app-content"> <!--Contenedor del Dashboard-->
                        <div class="container-fluid"> <!--Inicia Fila-->
                            <div class="row"> <!--Inicia Columna-->

                                <div class="col-lg-3 col-6"> <!--Grid Total-->
                                    <div class="small-box text-bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $total_no_compra; ?></h3>
                                            <p>Total de convocatorias</p>
                                        </div> 
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path transform="translate(1, 1)" d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"></path>
                                        </svg> <a href="./aviso-convocatoria/index.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            Ver todas las compras<i class="bi bi-link-45deg"></i> </a>
                                    </div>
                                </div>
                                <?php
                                try {
                                    $query = "SELECT COUNT(*) AS total_vigente
                                    FROM wp_portalcompra
                                    WHERE estado = 'vigente'";
                                    $stmt = $conn->query($query);
                                
                                    // Obtener el resultado
                                    $result = $stmt->fetch_assoc()['total_vigente'];
                                    if ($result) {
                                        $total_estado = $result; // Total de registros
                                    } else {
                                        $total_estado = 0; // Si no hay registros, devuelve 0
                                    }
                                } catch (PDOException $e) {
                                    // Manejo de errores
                                    echo "Error en la consulta: " . $e->getMessage();
                                    $total_estado = 0; // Valor predeterminado en caso de error
                                }
                                ?>
                                <div class="col-lg-3 col-6"> <!--Grid Vigentes-->
                                    <div class="small-box text-bg-success">
                                        <div class="inner">
                                        <h3><?php echo $total_estado; ?></h3>
                                            <p>Vigentes</p>
                                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path transform="translate(1, 1)" d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/>
                                            <path transform="translate(1, 1)" d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"></path>
                                        </svg> <a href="./aviso-convocatoria/vigente.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            Ver vigentes<i class="bi bi-link-45deg"></i> </a>
                                    </div>
                                </div> 
                                <?php
                                try {
                                    $query = "SELECT COUNT(*) AS total_adjudicados
                                    FROM wp_portalcompra
                                    WHERE estado = 'adjudicado'";
                                    $stmt = $conn->query($query);
                                
                                    // Obtener el resultado
                                    $result = $stmt->fetch_assoc()['total_adjudicados'];
                                    if ($result) {
                                        $total_estado = $result; // Total de registros
                                    } else {
                                        $total_estado = 0; // Si no hay registros, devuelve 0
                                    }
                                } catch (PDOException $e) {
                                    // Manejo de errores
                                    echo "Error en la consulta: " . $e->getMessage();
                                    $total_estado = 0; // Valor predeterminado en caso de error
                                }
                                ?>
                                <div class="col-lg-3 col-6"> <!--Grid Adjudicados-->
                                    <div class="small-box text-bg-danger">
                                        <div class="inner">
                                            <h3><?php echo $total_estado; ?></h3>
                                            <p>Adjudicados</p>
                                        </div>
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path transform="translate(1, 1)" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                        </svg> <a href="./aviso-convocatoria/adjudicados.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            Ver adjudicados<i class="bi bi-link-45deg"></i> </a>
                                    </div>
                                </div>
                                <?php
                                try {
                                    $query_cancelado = "SELECT COUNT(*) AS total_cancelado FROM wp_portalcompra WHERE estado = 'Desierto' OR estado = 'Cancelado'";
                                    $stmt_cancelado = $conn->query($query_cancelado);
                                    $result_cancelado = $stmt_cancelado->fetch_assoc()['total_cancelado'];
                                    $total_cancelado = $result_cancelado ? $result_cancelado : 0; // Si no hay registros, devuelve 0

                                } catch (PDOException $e) {
                                    // Manejo de errores
                                    echo "Error en la consulta: " . $e->getMessage();
                                    $total_cancelado = 0; // Valor predeterminado en caso de error
                                }
                                ?>
                                <div class="col-lg-3 col-6"> <!--Grid Cancelados-->
                                    <div class="small-box text-bg-success">
                                        <div class="inner">
                                        <h3><?php echo $total_cancelado; ?></h3>
                                            <p>Cancelado/Desierto</p>
                                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path transform="translate(1, 1)" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"></path>
                                        </svg> <a href="./aviso-convocatoria/cancelados.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            Ver cancelados y desiertos<i class="bi bi-link-45deg"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div> <!--L5-->
                    </div>
                    <div><br></div>
                    <div class="col-lg-6 col-6">
                        <h3 style="padding-left: 12px !important;" class="mb-0"><b>Orden de Compra</b></h3>
                        <p style="padding-left: 12px !important; color: #808080; margin-bottom: 10px !important;" class="mb-0">Compras menores a B./10,000.00</p>
                    </div>
                    <?php
                    try {
                        $query = "SELECT COUNT(no_compra) AS total FROM wp_ordencompra";
                        $stmt = $conn->query($query);

                        $result = $stmt->fetch_assoc()['total'];
                        if ($result) {
                            $total_no_compra = $result; // Total de registros
                        } else {
                            $total_no_compra = 0; // Si no hay registros, devuelve 0
                        }
                    } catch (PDOException $e) {
                        // Manejo de errores
                        echo "Error en la consulta: " . $e->getMessage();
                        $total_no_compra = 0; // Valor predeterminado en caso de error
                    }
                    ?>
                    <div class="app-content"> <!--Contenedor del Dashboard-->
                        <div class="container-fluid"> <!--Inicia Fila-->
                            <div class="row"> <!--Inicia Columna-->

                                <div class="col-lg-3 col-6"> <!--Grid Total-->
                                    <div class="small-box text-bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $total_no_compra; ?></h3>
                                            <p>Total de órdenes</p>
                                        </div> 
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                                            <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z"/>
                                        </svg> <a href="./orden-compra/index.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            Ver órdenes de compra<i class="bi bi-link-45deg"></i> </a>
                                    </div>
                                </div>
                    <!--L4-->
                </div> <!--L3-->
            </div> <!--L2-->
        </div> <!--L1-->
    </main>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/adminlte.js"></script>
</body><!--end::Body-->
<footer style="padding: 16px; color: #002F6C;">
    <div class="float-right">
        <b>Version</b> 2.0
    </div>
    <strong>© 2025 Portal de Compras.</strong> Todos los derechos reservados.
</footer>
</html>