<?php
session_start();
$logueado = false;
$_SESSION['previous_page'] = false;
$logueado = isset($_SESSION['user']);
$show_submenu = isset($_SESSION['show_submenu']);
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
include 'conexion.php'; 
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Datos de la pestaña del navegador-->
    <title>Reporte | Portal de Compras</title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Reporte | Portal de Compras">
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

    <script src="https://unpkg.com/@adminkit/core@latest/dist/js/app.js"></script>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php include 'menu.php';?>
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <h3 style="padding-top: 12px !important; padding-left: 12px !important;" class="mb-0"><b>Reporte de compras</b></h3>
                    </div>
                    <div class="app-content"> 
                        <div class="container-fluid"> 
                            <div class="container" style="margin-right: 0px !important; margin-left: 0px !important; margin-top: 30px;">
                                <h3 style="padding-top: 12px !important; padding-left: 12px !important;" class="mb-0"><b>Aviso de Convocatoria por estado en el año</b></h3>
                                <p style="padding-left: 12px !important; color: #808080; margin-bottom: 10px !important;" class="mb-0">Cantidad de compras entre B./10,000.00 y B./50,000.00 por estado</p>
                                <div class="row">
                                    <canvas id="chartjs-pie-curr" style="display: block; height: 300px; width: 609px;"></canvas>
                                </div>
                            </div>
                            <div class="container" style="margin-right: 0px !important; margin-left: 0px !important; margin-top: 30px;">
                                <h3 style="padding-top: 12px !important; padding-left: 12px !important;" class="mb-0"><b>Aviso de Convocatoria por estado general</b></h3>
                                <p style="padding-left: 12px !important; color: #808080; margin-bottom: 10px !important;" class="mb-0">Cantidad de compras entre B./10,000.00 y B./50,000.00 por estado</p>
                                <div class="row">
                                    <canvas id="chartjs-pie-gen" style="display: block; height: 300px; width: 609px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
    $(document).ready(function() {
        $.ajax({
            url: 'generar_reporte.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                const total = response.data.reduce((a, b) => a + b, 0);
                new Chart(document.getElementById("chartjs-pie-gen"), {
                    type: "doughnut",
                    data: {
                        labels: response.labels,  
                        datasets: [{
                            data: response.data,
                            backgroundColor: response.backgroundColor,
                            borderColor: "transparent"
                        }]
                    },           
                    options: {
                        maintainAspectRatio: false,
                        cutoutPercentage: 65,
                        plugins: {
                            datalabels: {
                                color: '#fff',
                                formatter: function(value, context) {
                                    let porcentaje = ((value / total) * 100).toFixed(1);
                                    return porcentaje + '%';
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                new Chart(document.getElementById("chartjs-pie-curr"), {
                    type: "doughnut",
                    data: {
                        labels: response.labels2,  
                        datasets: [{
                            data: response.data2,
                            backgroundColor: response.backgroundColor,
                            borderColor: "transparent"
                        }]
                    },           
                    options: {
                        maintainAspectRatio: false,
                        cutoutPercentage: 65,
                        plugins: {
                            datalabels: {
                                color: '#fff',
                                formatter: function(value, context) {
                                    let porcentaje = ((value / total) * 100).toFixed(1);
                                    return porcentaje + '%';
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            },       
            error: function(xhr, status, error) {
                console.error("Error al cargar los datos:", error);
            }
        });
    });
    </script>
</body>
</html>