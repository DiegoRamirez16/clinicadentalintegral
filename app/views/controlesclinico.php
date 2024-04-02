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
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/tables.css">
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Controles Clinico</title>
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
            <!-- Inicio del Div del titulo, boton agregar nuevo y cuadro de busqueda -->
            <div class="contentpage" id="contentList">
                <div class="addntitle">
                    <h4 class="titulolist">
                        <img src="<?php echo URL;?>public_html/iconos/listado32.png" alt="x"/>
                        Listado de Controles Clinicos <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nuevo Control</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar controles" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->
            <div id="contentList2">
                <!-- Inicio de la tabla-->
                    <div id="contentTable">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <th>ID Ctrl</th>
                                <th>Tratamiento</th>
                                <th>Fecha Control</th>
                                <th>Diagnostico</th>
                                <th>Observacion</th>
                                <th>Exp</th>
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
            <!--Incio de formulario -->
            <div id="contentForm" class="contact-form mt-3 d-none">
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

                    <label for="id_expediente">Expediente:</label>
                    <div class="selectform">
                        <select name="id_expediente" id="id_expediente" class="form-select">
                        </select>
                    </div>

                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                    </div>
                </form>
            </div>
            <!--Fin de formulario de libros -->
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/controlesclinico.js"></script>
</body>
</html>