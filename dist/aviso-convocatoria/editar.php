<?php
    session_start();
    $logueado = false;
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }else{
        $logueado = isset($_SESSION['usuario']);
    }

    include '../conexion.php'; // Incluir el archivo de conexión
    $successMessage = "";

    // Obtener el ID del registro a editar
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Consultar el registro actual para rellenar el formulario
    $query_i = "SELECT * FROM wp_portalcompra WHERE id = ?";
    $stmt_i = $conn->prepare($query_i);
    $stmt_i->bind_param("i", $id);
    $stmt_i->execute();
    $result_i = $stmt_i->get_result();

    if ($result_i->num_rows > 0) {
        $record_i = $result_i->fetch_assoc(); 
        // Obtener documentos relacionados solo si la compra fue encontrada
        $sql_f = "SELECT * FROM wp_docompra WHERE id_pcompra = ? ORDER BY date";
        $stmt_f = $conn->prepare($sql_f);
        $stmt_f->bind_param("i", $record_i['id']); // Suponiendo que 'id' es el campo clave primaria de wp_portalcompra
        $stmt_f->execute();
        $result_f = $stmt_f->get_result(); // Obtener el resultado de los documentos
        // Consulta para obtener el proponente
        $sql_p = "SELECT * FROM wp_proponentes WHERE id_pcompra = ?";
        $stmt_p = $conn->prepare($sql_p);
        $stmt_p->bind_param("i", $record_i['id']); // Suponiendo que 'id' es el campo clave primaria
        $stmt_p->execute();
        $result_p = $stmt_p->get_result();
    } else {
        // Si no se encuentra el registro
        $record_i = null;
        $result_f = null;
        $result_p = null;
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--Datos de la pestaña del navegador-->
    <title>Editar Registro | <?php echo htmlspecialchars($record_i['no_compra']); ?></title>
    <link rel="shortcut icon" href="https://alcaldiasanmiguelito.gob.pa/wp-content/uploads/2024/10/cropped-Escudo-AlcaldiaSanMiguelito-RGB_Vertical-Blanco.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="https://tabler.io/tabler/assets/css/dashboard.css">
    <link rel="stylesheet" href="..\css\estilos-pc-asm.scss">
    <link rel="stylesheet" href="..\css\adminlte.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php include '..\menu.php';?>
    <main class="app-main" style="padding: 20px;">
    <form method="POST" action="actualizar.php">
        <div class="row g-3">
            <div class="col">
                <h5 class="nombre-pc">
                    <a onClick="javascript:history.go(-1)">
                        <i style="margin-right: 10px; text-decoration:none;" class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                    Editar compra
                </h5>
            </div>
            <div class="col col-lg-2">
                <button style="color: white; background-color: #009639" type="submit" class="btn"><i class="bi bi-floppy2-fill"></i> Actualizar Compra</button>
            </div>
            <div class="col-md-auto">
                <a style="color: white; background-color: #D50032" onClick="javascript:history.go(-1)" class="btn"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true"><i class="bi bi-info-square-fill"></i> Información General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false"><i class="fas fa-file-upload"></i> Archivos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="prop-tab" data-bs-toggle="tab" data-bs-target="#prop" type="button" role="tab" aria-controls="prop" aria-selected="false"><i class="bi bi-building-add"></i> Proponentes</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div class="">
                    <!-- Main Content -->
                    <div class="content">
                        <div class="container-fluid" style="padding: 0px !important;">
                            <div class="card card-primary">
                                <!--<form method="POST" action="editar.php">-->
                                    <div class="card-body">
                                        <input type="hidden" id="id" name="id" value="<?php echo $record_i['id']; ?>">
                                        <div class="form-group">
                                            <label class="req" for="no_compra">Número de Compra</label>
                                            <input type="text" class="form-control" id="no_compra" name="no_compra" value="<?php echo $record_i['no_compra']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="tipo_procedimiento">Tipo de Procedimiento</label>
                                            <textarea type="text" class="form-control" id="tipo_procedimiento" name="tipo_procedimiento" required><?php echo htmlspecialchars($record_i['tipo_procedimiento']); ?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="req" for="objeto_contractual">Objeto Contractual</label>
                                            <input type="text" class="form-control" id="objeto_contractual" name="objeto_contractual" value="<?php echo htmlspecialchars($record_i['objeto_contractual']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="descripcion">Descripción</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese una descripción" rows="3" required><?php echo htmlspecialchars($record_i['descripcion']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="fecha_publicacion">Fecha de Publicación</label>
                                            <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo htmlspecialchars($record_i['fecha_publicacion']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="tipo_procedimiento">Fecha de Presentación</label>
                                            <input type="datetime-local" class="form-control" id="fecha_presentacion" name="fecha_presentacion" value="<?php echo htmlspecialchars($record_i['fecha_presentacion']); ?>"  required>
                                        </div>
                                                    <div class="form-group">
                                            <label class="req" for="fecha_apertura">Fecha de Apertura</label>
                                            <input type="datetime-local" class="form-control" id="fecha_apertura" name="fecha_apertura" value="<?php echo htmlspecialchars($record_i['fecha_apertura']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="lugar_presentacion">Lugar de Presentación</label>
                                            <input type="text" class="form-control" id="lugar_presentacion" name="lugar_presentacion" value="<?php echo htmlspecialchars($record_i['lugar_presentacion']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="req" for="termino_subsanacion">Término de Subsanación</label>
                                            <input type="text" class="form-control" id="termino_subsanacion" name="termino_subsanacion" value="<?php echo htmlspecialchars($record_i['termino_subsanacion']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="req" for="precio_referencia">Precio de Referencia</label>
                                            <input type="number" step="1.00" min="10000" max="50000" class="form-control" id="precio_referencia" name="precio_referencia" value="<?php echo htmlspecialchars($record_i['precio_referencia']); ?>" oninput="limitDecimals(this)" required>
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
                                            <label class="req" for="partida_presupuestaria">Partida Presupuestaria</label>
                                            <input type="text" class="form-control" id="partida_presupuestaria" name="partida_presupuestaria" value="<?php echo htmlspecialchars($record_i['partida_presupuestaria']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="req" for="modalidad_adjudicacion">Modalidad de Adjudicación</label>
                                            <input type="text" class="form-control" id="modalidad_adjudicacion" name="modalidad_adjudicacion" value="<?php echo htmlspecialchars($record_i['modalidad_adjudicacion']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="req" for="provincia_entrega">Provincia de Entrega</label>
                                            <input type="text" class="form-control" id="provincia_entrega" name="provincia_entrega" value="<?php echo htmlspecialchars($record_i['provincia_entrega']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="req" for="estado">Estado</label>
                                            <select class="form-control" id="estado" name="estado" required>
                                                <option value="Vigente" <?php echo $record_i['estado'] === 'Vigente' ? 'selected' : ''; ?>>Vigente</option>
                                                <option value="Adjudicado" <?php echo $record_i['estado'] === 'Adjudicado' ? 'selected' : ''; ?>>Adjudicado</option>
                                                <option value="Cancelado" <?php echo $record_i['estado'] === 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                                <option value="Desierto" <?php echo $record_i['estado'] === 'Desierto' ? 'selected' : ''; ?>>Desierto</option>
                                            </select>
                                        </div>
                                    </div>
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ----------------------------------------------------------------------------- -->
            <!------------------- Formulario para subir archivo --------------------------------->
            <!-- ----------------------------------------------------------------------------- -->
            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                <div class="container" style="margin-left: 0px; margin-right: 0px !important; max-width: 100% !important;">
                    <!--<form method="POST" class="frm-edit-pc" action="" enctype="multipart/form-data" style="padding-right: 10px !important; padding-left: 10px !important; margin-bottom: 50px;">-->
                        <div id="itemContainer">
                            <!-- Fila de entrada dinámica -->
                            <h5>Agregar nuevos documentos</h5><br>
                        </div>
                        <button type="button" class="btn" style="background-color: #00A9E0; color: white; margin-bottom: 20px;" id="addRowBtn"><i class="fa-solid fa-square-plus"></i> Agregar otro documento</button>
                    <!--</form>-->
                    <div class="cont-portal" style="padding-right: 10px !important; padding-left: 10px !important;">
                        <?php if ($result_f && $result_f->num_rows > 0): ?>
                        <div class="table-box-pc tb-pc-1">
                            <table>
                                <thead>
                                    <tr>
                                        <th> </th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($record_f = $result_f->fetch_assoc()): 
                                        $fecha_mod = date("d-m-Y", strtotime($record_f['date']));?>
                                        <tr>
                                            <td><i style="color: #002F6C" class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                            <td><?php echo htmlspecialchars($record_f['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($fecha_mod); ?></td>
                                            <td><a class="btn badge-estado" href="uploads/<?php echo htmlspecialchars($record_f['pdf']); ?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>  Ver PDF</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                            <?php else: ?>
                                <p>No hay documentos relacionados con esta compra.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    // JavaScript para agregar más filas dinámicamente
                    let rowCount = 1;
                    $('#addRowBtn').click(function() {
                        let newRow = `
                            <div class="row mb-3" id="item${rowCount}">
                                <div class="col">
                                    <input type="text" name="items[${rowCount}][nombre]" class="form-control" placeholder="Nombre del Documento" required>
                                </div>
                                <div class="col col-lg-2">
                                    <input type="date" name="items[${rowCount}][date]" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col">
                                    <input type="file" name="pdf[]" class="form-control" required>
                                </div>
                                <div class="col-auto">
                                    <button id="btn-dlt" type="button" style="background-color: #D50032; color: white;" class="btn form-control" onclick="removeRow(${rowCount})"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            </div>
                        `;
                        $('#itemContainer').append(newRow);
                        rowCount++;
                    });

                    // Función para eliminar una fila si está vacía
                    function removeRow(rowId) {
                        const row = $('#item' + rowId);
                        const inputNombre = row.find('input[name="items[' + rowId + '][nombre]"]').val();
                        const inputFecha = row.find('input[name="items[' + rowId + '][date]"]').val();

                        if (inputNombre === "" && inputFecha === "" || inputNombre == undefined && inputFecha == undefined || inputNombre == null && inputFecha == null) {
                            console.log("Uno");
                            row.remove();
                        } else {
                            alert('No se puede eliminar esta fila ya que contiene datos.');
                        }
                    }
                </script>
        


            <!-- ----------------------------------------------------------------------------- -->
            <!------------------- Formulario para agregar proponentes --------------------------->
            <!-- ----------------------------------------------------------------------------- -->
            <div class="tab-pane fade" id="prop" role="tabpanel" aria-labelledby="prop-tab">
                <div class="container" style="margin-left: 0px; margin-right: 0px !important; max-width: 100% !important;">
                    <!-- Formulario -->
                    <!--<form method="POST" action="" class="frm-edit-pc" style="padding-right: 10px !important; padding-left: 10px !important; margin-bottom: 50px;">-->
                        <div id="itemContainer2" style="margin-bottom: 16px;">
                            <h5>Agregar nuevos proponentes</h5><br>
                        </div>
                        <button type="button" class="btn" style="background-color: #00A9E0; color: white; margin-bottom: 20px;" id="addRowBtn2"><i class="fa-solid fa-square-plus"></i> Agregar otro proponente</button>
                    <!--</form>-->

                    <?php if ($result_p && $result_p->num_rows > 0): ?>
                        <div class="cont-portal" style="padding-right: 10px !important; padding-left: 10px !important;">
                            <div class="table-box-pc tb-pc-1">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Oferta</th>
                                            <th>Hora</th>
                                            <th>Adjudicado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($record_p = $result_p->fetch_assoc()):?>
                                            <tr class="row-color">
                                                <?php $p_oferta = number_format($record_p['oferta'], 2, '.', ',');
                                                      $h_prop = date("h:i A", strtotime($record_p['hora']));
                                                ?>
                                                <td><?php echo htmlspecialchars($record_p['proponente']); ?></td>
                                                <td>B/. <?php echo htmlspecialchars($p_oferta); ?></td>
                                                <td><?php echo htmlspecialchars($h_prop); ?></td>
                                                <td><span class="badge-color"><?php echo htmlspecialchars($record_p['aprobado']); ?></span></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="cont-portal">No se encontraron proponentes para esta compra.</p>
                    <?php endif; ?>
                    <!-- Mensaje -->
                    <?php if (!empty($message)): ?>
                        <div class="notification"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <a onClick="javascript:history.go(-1)" style="background-color: #D50032; color: white;" class="btn">
                        <i class="bi bi-arrow-left-circle-fill"></i>
                        Volver a Lista de Compras
                    </a>
                </div>
            </div>
            <script>
                // JavaScript para agregar más filas dinámicamente
                let rowCount2 = 1;
                $('#addRowBtn2').click(function() {
                    let newRow2 = `
                        <div class="row" id="2item${rowCount2}">
                            <div class="col">
                                <input type="text" class="form-control" id="proponente" name="items[${rowCount2}][proponente]" placeholder="Nombre de la empresa" required>
                            </div>
                            <div class="col-lg-2">
                                <input type="number" min="10000" max="50000" step="0.01" class="form-control" id="oferta" placeholder="Oferta de la empresa" name="items[${rowCount2}][oferta]" required>
                            </div>
                            <div class="col-lg-2">
                                <input type="time" class="form-control" id="hora" name="items[${rowCount2}][hora]" required>
                            </div>
                            <div class="col-lg-2">
                                <select style="padding-top: 5px; padding-bottom: 5px;" class="form-control" id="aprobado" name="items[${rowCount2}][aprobado]">
                                    <option selected="true" disabled="disabled">¿Adjudicado?</option>
                                    <option value="No">No</option>    
                                    <option value="Si">Si</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button id="btn-dlt" type="button" style="background-color: #D50032; color: white;" class="btn form-control" onclick="removeRow2(${rowCount2})"><i class="bi bi-trash3-fill"></i></button>
                            </div>
                        </div>
                    `;
                    $('#itemContainer2').append(newRow2);
                    rowCount2++;
                });

                // Función para eliminar una fila si está vacía
                function removeRow2(rowId) {
                    const row = $('#2item' + rowId);
                    const inputProponente = row.find('input[name="items[' + rowId + '][proponente]"]').val();
                    const inputOferta = row.find('input[name="items[' + rowId + '][oferta]"]').val();

                    if (inputProponente === "" && inputOferta === "" || inputProponente == undefined && inputOferta == undefined || inputProponente == null && inputOferta == null) {
                        row.remove();
                    } else {
                        alert('No se puede eliminar esta fila ya que contiene datos.');
                    }
                }
            </script>
        </div>
    </form>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/adminlte.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var elementos = document.querySelectorAll('.badge-color');
            var filas = document.querySelectorAll('.row-color');
            elementos.forEach(function(elemento) {
                if (elemento.textContent.includes('Adjudicado')||elemento.textContent.includes('Si')){
                elemento.classList.add('adjudicado');
                }else if (elemento.textContent.includes("Vigente")){
                elemento.classList.add("vigente");
                }else{
                elemento.classList.add("cancelado-desierto");
                }
            });
            filas.forEach(function(fila) {
                if (fila.textContent.includes('Si')){
                fila.classList.add('active-adj');
                }
            });
        });
    </script>
</body>
</html>
