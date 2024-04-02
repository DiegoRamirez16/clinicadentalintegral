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
    <title>Pacientes</title>
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
            <hr class="line1">
            <!-- Cantidad de pacientes -->
            <div class="cantdiv">
                <img class="imgcalendar" src="<?php echo URL;?>public_html/iconos/people64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Total Pacientes</h4>
            <h4 class="canthoynum" id="totalpacientes">0</h4>
            <hr class="line1">
            <!-- Cantidad de pacientes -->
            <div class="cantdiv">
                <img class="imgcalendar" src="<?php echo URL;?>public_html/iconos/masculine64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Masculinos</h4>
            <h4 class="canthoynum" id="totalmas">0</h4>
            <hr class="line1">
            <!-- Cantidad de pacientes -->
            <div class="cantdiv">
                <img class="imgcalendar" src="<?php echo URL;?>public_html/iconos/female64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Femeninos</h4>
            <h4 class="canthoynum" id="totalfem">0</h4>
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
                        Listado de pacientes <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nuevo Paciente</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar un paciente" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <div class="contentpageOP" id="contentListOP">
                <div class="addntitle">
                        <!-- Boton Ver pacientes masculinos -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pacientes/getAllMasculino')"><span class="opcionestxt">Masculino</span></button>
                        <!-- Boton Ver pacientes femeninos -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pacientes/getAllFemenino')"><span class="opcionestxt">Femenino</span></button>
                        <!-- Boton Ver todos -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pacientes/getAll')"><span class="opcionestxt">Todos</span></button>              
                    <hr>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->

            <!-- listado de pacientes -->
            <div id="contentList2">
                <!-- Inicio de la tabla-->
                    <div class="contentT" id="contentTable">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Telefono</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Sexo</th>
                                <th>Observacion</th>
                                <th>Alergia</th>
                                <th>Padecimientos</th>
                                <th>Perfil-Editar-Eliminar</th>
                            </thead>
                            <tbody>
                                <td>1</td>
                                <td>Diego Ernesto</td>
                                <td>Ramirez Rivera</td>
                                <td>7778-5842</td>
                                <td>16-03-2001</td>
                                <td>Masculino</td>
                                <td>
                                    <button class="addctrlbtn" type="button" id="perfilPaciente" onclick="perfilPaciente(${item.id_paciente})"><img src="public_html/iconos/profile24.png" alt="x"/></button>
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
            <!--Incio de formulario -->
            <div id="contentForm" class="contact-form mt-3 d-none">
                <span class="agregartxt">Paciente</span>
                <form id="formPaciente" enctype="multipart/form-data">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="0">

                    <label for="nombre_paciente">Nombre:</label>
                    <input type="text" id="nombre_paciente" name="nombre_paciente" required>

                    <label for="apellido_paciente">Apellido:</label>
                    <input type="text" id="apellido_paciente" name="apellido_paciente" required>

                    <label for="telefono_paciente">Telefono:</label>
                    <input type="text" id="telefono_paciente" name="telefono_paciente" required>

                    <label for="fecha_nacimiento">Fecha Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

                    <label for="sexo_paciente">Sexo:</label>
                    <div class="selectform">
                        <select name="sexo_paciente" id="sexo_paciente" class="form-select">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <label for="observacion_paciente">Observación:</label>
                    <textarea id="observacion_paciente" name="observacion_paciente" required></textarea>

                    <label for="alergia_paciente">Alergia:</label>
                    <textarea id="alergia_paciente" name="alergia_paciente" required></textarea>

                    <label for="padecimiento_paciente">Padecimiento:</label>
                    <textarea id="padecimiento_paciente" name="padecimiento_paciente" required></textarea>

                    <input type="hidden" name="exp" id="expe" value="0">
                    
                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                    </div>
                </form>
                <!--Fin de formulario de paciente -->
            </div>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/pacientes.js"></script>
</body>
</html>