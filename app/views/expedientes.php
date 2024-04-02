<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS fijos -->
    <?php include_once "app/views/sections/css.php"; ?>
    <!-- CSS Referencias propias -->
    <!-- CSS de las paginas -->
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/paginas.css">
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/modal.css">
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/tables.css">
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Expediente Clinico</title>
</head>
<body>
    <div class="contenedor">
        <!-- Menu de navegacion -->
        <section id="menu">
            <?php
            if ($_SESSION["tipo"]=="admin") {
                include_once "app/views/sections/menugeneral.php";
            } else {
                include_once "app/views/sections/menugeneraluser.php";
            } 
        ?>
        </section>

        <!-- Inicio Divicion Pantalla Barra lateral -->
        <!-- Contenido de la primera mitad de la pantalla -->
        <div class="mitad1">
            <!-- Icono de usuario en la barra lateral -->
            <div class="iconouser">
                <img src="<?php echo URL;?>public_html/iconos/dentist64.png" alt="">
            </div>
            <!-- Nombre del usuario que ha iniciado sesion en la barra lateral -->
            <div style="text-align: center;" >
                <span class="userid">&nbsp;&nbsp;<?php echo $_SESSION["nuser"];?></span>
            </div>
        </div>
        <!-- Fin Divicion Pantalla Barra lateral -->

        <!-- Inicio Divicion Segunda Pantalla donde estan el menu y sus opciones -->
        <!-- Contenido de la segunda mitad de la pantalla -->
        <div class="mitad2">
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1>Controles Clinicos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="contentList2">
                            <!-- Inicio de la tabla-->
                            <div class="contentT" id="contentTableC">
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <th>ID CTRL</th>
                                        <th>Tratatamiento</th>
                                        <th>Fecha</th>
                                        <th>Diagnostico</th>
                                        <th>Observacion</th>
                                        <th>Expediente</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        <td>1</td>
                                        <td>NameTrat</td>
                                        <td>13-23-2022</td>
                                        <td>Listo</td>
                                        <td>Paciente bien</td>
                                        <td>Name</td>
                                        <td>
                                            <button class="editarbtn" type="button"><img src="<?php echo URL;?>public_html/iconos/edit.png" alt="x"/></button>
                                            <button class="eliminarbtn" type="button"><img src="<?php echo URL;?>public_html/iconos/trash.png" alt="x"/></button>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Fin de la tabla -->
                            <!--Paginacion -->
                            <div class="row">
                                <nav class="d-flex justify-content-center">
                                    <ul class="paginationC ">
                                        <li class="page-itemC"><a class="page-linkC" href="#">Anterior</a></li>
                                        <li class="page-itemC"><a class="page-linkC" href="#">1</a></li>
                                        <li class="page-itemC"><a class="page-linkC" href="#">2</a></li>
                                        <li class="page-itemC"><a class="page-linkC" href="#">3</a></li>
                                        <li class="page-itemC"><a class="page-linkC" href="#">Siguiente</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Fin de paginacion -->
                        </div>
                        <!--Incio de formulario Controles -->
                        <div id="contentFormC" class="contact-form mt-3 d-none">
                            <span class="agregartxt">Controles Clinicos</span>
                            
                            <form id="formControlClinico" enctype="multipart/form-data">
                                <input type="hidden" name="id_controles" id="id_controles" value="0">

                                <label for="id_tratamiento">Tratamientos:</label>
                                <div class="selectform">
                                    <select name="id_tratamiento" id="id_tratamiento" class="form-select">
                                    </select>
                                </div>

                                <label for="fecha_control">Fecha Control:</label>
                                <input type="date" id="fecha_control" name="fecha_control" required>

                                <label for="diagnostico">Diagnostico:</label>
                                <textarea id="diagnostico" name="diagnostico" required></textarea>

                                <label for="observacion_control">Observación:</label>
                                <textarea id="observacion_control" name="observacion_control" required></textarea>

                                <div class="selectform">
                                    <input type="hidden" name="id_expediente" id="id_expediente" class="form-select">
                                </div>

                                <div class="formbtn">
                                    <button class="savebtn" type="submit" id="btnAgregarControl">Guardar</button>
                                    <button class="savebtn d-none" type="submit" id="btnGuardarCambios">Guardar Cambios</button>
                                    <button class="cancelbtn" type="button" id="btnCancelarC" onclick="cancelarControlClinico">Cancelar</button>
                                    
                                </div>
                            </form>
                        </div>
                        <!--Fin de formulario de controles -->
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btncerrar" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--Fin modal-->
            <!-- Inicio del Div del titulo, boton agregar nuevo y cuadro de busqueda -->
            <div class="contentpage" id="contentListMenu">
                <div class="addntitle">
                    <h4 class="titulolist">
                        <img src="<?php echo URL;?>public_html/iconos/listado32.png" alt="x"/>
                        Listado de Expedientes <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nuevo Expediente</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar un expediente" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->

            <!-- listado de expedientes -->
            <div id="contentList">
                <!-- Inicio de la tabla-->
                <div class="contentT" id="contentTable">
                    <table class="table">
                        <thead class="table-dark">
                            <th>ID Expediente</th>
                            <th>Nombre Paciente</th>
                            <th>Apellido Paciente</th>
                            <th>Motivo Consulta</th>
                            <th>Fecha expediente</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>Carlos Francisco</td>
                            <td>Ruiz Cortez</td>
                            <td>Dientes sucios </td>
                            <td>16-03-2022</td>
                            <td>
                                <button class="addctrlbtn" type="button" id="agregarC" onclick="agregarC(${item.id_expediente})"><img src="public_html/iconos/add24.png" alt="x"/></button>
                                <button class="editarbtn" type="button"><img src="<?php echo URL;?>public_html/iconos/edit.png" alt="x"/></button>
                                <button class="eliminarbtn" type="button"><img src="<?php echo URL;?>public_html/iconos/trash.png" alt="x"/></button>
                            </td>
                        </tbody>
                    </table>
                </div>
                <!-- Fin de la tabla -->
                <!--Paginacion -->
                <div class="paginacion">
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Fin de paginacion -->
            </div>
            <!-- Fin del listado -->
            <!--Incio del formulario Expediente -->
            <div id="contentForm" class="contact-form mt-3 d-none">
                <span class="agregartxt">Expediente</span>
                <form id="formExpediente" enctype="multipart/form-data">
                    <input type="hidden" name="id_expediente" id="id_expediente" value="0">

                    <label for="id_paciente">Nombre Paciente:</label>
                    <div class="selectform">
                        <select name="id_paciente" id="id_paciente" class="form-select">
                        </select>
                    </div>

                    <label for="motivo_consulta">Motivo Consulta:</label>
                    <textarea id="motivo_consulta" name="motivo_consulta" required></textarea>

                    <label for="fecha_expediente">Fecha Expediente:</label>
                    <input type="date" id="fecha_expediente" name="fecha_expediente" required>

                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="savebtn d-none" type="submit" id="btnGuardarCambios">Guardar Cambios</button>
                        <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                    </div>
                </form>
            </div>
            <!--Fin del formulario Expediente -->
            <!--Incio del formulario Cambios Expediente -->
            <div id="contentFormExpecambios" class="contact-form mt-3 d-none">
                <span class="agregartxt">Editar Expediente</span>
                <form id="formExpecambios" enctype="multipart/form-data">
                    <input type="hidden" name="id_expedientec" id="id_expedientec">

                    <label for="id_pacientec">Nombre Paciente:</label>
                    <div class="selectform">
                        <select name="id_pacientec" id="id_pacientec" class="form-select">
                        </select>
                    </div>

                    <label for="motivo_consulta">Motivo Consulta:</label>
                    <textarea id="motivo_consultac" name="motivo_consultac" required></textarea>

                    <label for="fecha_expediente">Fecha Expediente:</label>
                    <input type="date" id="fecha_expedientec" name="fecha_expedientec" required>

                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnGuardarCambios">Guardar Cambios</button>
                        <button class="cancelbtn" type="button" id="btnCancelarCambios">Cancelar</button>
                    </div>
                </form>
            </div>
            <!--Fin del formulario Expediente -->
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/expedientes.js"></script>
</body>
</html>