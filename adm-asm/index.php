<?php
    session_start();
    $logueado = false;
    $_SESSION['previous_page'] = false;
    if (!isset($_SESSION['user'])) {
        header("Location: ../dist/login.php");
        exit;
    }else{
        $logueado = isset($_SESSION['user']);
    }
    $show_submenu = isset($_SESSION['show_submenu']);
    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
    include '../dist/conexion.php';

    if (isset($_SESSION['mensaje_adm'])) {
        echo "<script>alert('{$_SESSION['mensaje_adm']}');</script>";
        unset($_SESSION['mensaje_adm']); // Elimina el mensaje para que no se repita
    }

    $sql = "SELECT * 
        FROM user_compra
        ORDER BY id DESC";
    $sql_pend = "SELECT *
                FROM user_temp
                WHERE estado = 0";
    $result = $conn->query($sql);
    $result_pend = $conn->query($sql_pend);

    if ($result === false) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($result_pend === false) {
        die("Error en la consulta: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | Portal de Compras</title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Administración | Portal de Compras">
    <meta name="author" content="Alcaldía de San Miguelito">
    <meta name="description" content="Portal de Compras de la Alcaldía de San Miguelito. Creado con el objetivo de ser transparente con nuestros vecinos y brindar información inmediata a nuestros proveedores.">
    <meta name="keywords" content="portal de compras, alcaldia de san miguelito, municipio de san miguelito"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="..\dist\css\adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="..\dist\css\estilos-pc-asm.scss">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> 
<?php include '../dist/menu.php';?>
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="">
            <section>
                <div class="title-table-pc container-fluid text-center">
                    <h2><b>Administración de Portal</b></h2>
                </div>
            </section>

            <section class="content cont-pc">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                        <button type="button" class="btn" style="background-color: #00A9E0; color: white; margin-bottom: 20px;" data-bs-toggle="modal" data-bs-target="#modalCreateUser"><i class="bi bi-person-fill-add"></i> Agregar usuario</button>
                            <div class="table-box-pc tb-pc-1">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Departamento</th>
                                            <th>Creación</th>
                                            <th>Modificación</th>
                                            <th>Creado por</th>
                                            <th>Rol</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): 
                                            $f_creacion = date("d-m-Y", strtotime($row['created_date']));
                                            $f_modificacion = date("d-m-Y h:i A", strtotime($row['edit_date']));?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['user']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['departamento']); ?></td>
                                            <td><?php echo htmlspecialchars($f_creacion); ?></td>
                                            <td><?php echo htmlspecialchars($f_modificacion); ?></td>
                                            <td><?php echo htmlspecialchars($row['created_user']); ?></td>
                                            <td><span class="badge-color adjudicado"><?php echo htmlspecialchars($row['rol']); ?></span></td>
                                            <td>
                                                <a onclick="abrirModalEditUser(<?php echo htmlspecialchars($row['id']); ?>, '<?php echo htmlspecialchars($row['nombre']); ?>', '<?php echo htmlspecialchars($row['apellido']); ?>', '<?php echo htmlspecialchars($row['departamento']); ?>', '<?php echo htmlspecialchars($row['email']); ?>', '<?php echo htmlspecialchars($row['user']); ?>', '<?php echo htmlspecialchars($row['rol']); ?>')" data-bs-toggle="modal" data-bs-target="#modalEditUser" class="btn btn-sm"><i class="fas fa-edit"></i></a>
                                                <a onclick="resetPass('<?php echo htmlspecialchars($row['iuser']); ?>')" style="background-color: #FFCD00; color: #002F6C;" class="btn btn-sm">
                                                    <i class="bi bi-key-fill"></i>
                                                </a>
                                                <a style="background-color: #D50032;" href="tcpdf/reporte.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-sm">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <!-- Modal actualización de usuario -->
                                <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="editar_user.php">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditUserLabel">Actualizar Usuario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <input type="hidden" name="id" id="id_modal_user">
                                                        <div class="form-group">
                                                            <label class="req" for="nombre">Nombre</label>
                                                            <input type="text" class="form-control" name="nombre" id="nombre_modal_user" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="apellido">Apellido</label>
                                                            <input type="text" class="form-control" name="apellido" id="apellido_modal_user" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="" for="departamento">Departamento</label>
                                                            <input type="text" class="form-control" name="departamento" id="departamento_modal_user">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="email">Correo</label>
                                                            <input type="text" class="form-control" name="email" id="email_modal_user" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="user">Usuario</label>
                                                            <input type="text" class="form-control" name="user" id="user_modal_user" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="rol">Rol</label>
                                                            <select class="form-control" name="rol" id="rol_modal_user" required>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Supervisor">Supervisor</option>
                                                                <option value="Analista de compra">Analista de compra</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" style="background-color: #009639; color: white;" class="btn">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal creación de usuario -->
                                <div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="create_user.php">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalCreateUserLabel">Nuevo Usuario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label class="req" for="nombre">Usuario</label>
                                                            <input type="text" class="form-control" name="nombre"required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="apellido">Apellido</label>
                                                            <input type="text" class="form-control" name="apellido" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="" for="departamento">Departamento</label>
                                                            <input type="text" class="form-control" name="departamento">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="email">Correo</label>
                                                            <input type="text" class="form-control" name="email" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="user">Usuario</label>
                                                            <input type="text" class="form-control" name="user" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="temp_pass">Contraseña Temporal</label>
                                                            <input type="text" class="form-control" name="temp_pass" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="req" for="rol">Rol</label>
                                                            <select class="form-control" name="rol" required>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Supervisor">Supervisor</option>
                                                                <option value="Analista de compra" selected>Analista de compra</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" style="background-color: #009639; color: white;" class="btn">Crear</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content cont-pc">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                        <h4><i class="bi bi-hourglass-split"></i> Usuarios sin activar</h4>
                            <div class="table-box-pc tb-pc-1">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Contraseña Univelsal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row_pend = $result_pend->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row_pend['user']); ?></td>
                                            <td><?php echo htmlspecialchars($row_pend['universal_pass']); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //-----Modal para reiniciar contraseña
    function resetPass(user){
            Swal.fire({
                title: "¿Estás seguro que deseas reiniciar la contraseña?",
                text: "¡No podrás revertir esto!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#D50032",
                cancelButtonColor: "#777777",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX para eliminar el proponente
                    $.ajax({
                        url: 'reset_pass_user.php',
                        type: 'POST',
                        data: {user:user},
                        success: function(respuesta) {
                            Swal.fire("¡Contraseña reiniciada!", respuesta, "success");
                            location.reload();
                        },
                        error: function() {
                            Swal.fire("Error", "No se pudo cambiar contraseña.", "error");
                        }
                    });
                } else {
                    console.log("Cancelado");
                }
            });
        }
</script>
<footer style="padding: 16px; color: #002F6C;">
    <div class="float-right">
        <b>Version</b> 2.0
    </div>
    <strong>© 2025 Portal de Compras.</strong> Todos los derechos reservados.
</footer>
<script>
    function abrirModalEditUser(id, nombre, apellido, departamento, email, user, rol){
        const idInput = document.getElementById('id_modal_user');
        const nombreInput = document.getElementById('nombre_modal_user');
        const apellidoInput = document.getElementById('apellido_modal_user');
        const departamentoInput = document.getElementById('departamento_modal_user');
        const emailInput = document.getElementById('email_modal_user');
        const userInput = document.getElementById('user_modal_user');
        const rolInput = document.getElementById('rol_modal_user');
        idInput.value = id;
        nombreInput.value = nombre;
        apellidoInput.value = apellido;
        departamentoInput.value = departamento;
        emailInput.value = email;
        userInput.value = user;
        rolInput.value = rol;
    }
</script>
</html>