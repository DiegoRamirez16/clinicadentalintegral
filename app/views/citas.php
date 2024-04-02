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
    <title>Citas</title>
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
            <!-- Cantidad de citas para hoy -->
            <div class="cantdiv">
                <img class="imgcalendar" src="<?php echo URL;?>public_html/iconos/calendar64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Citas para hoy</h4>
            <h4 class="canthoynum" id="totalcitas">0</h4>
            <hr class="line1">
            <!-- Cantidad de citas para ma -->
            <h4 class="canthoytxt">Citas para mañana</h4>
            <h4 class="canthoynum" id="totalcitasma">0</h4>
        </div>
        <!-- Fin Divicion Pantalla Barra lateral -->

        <!-- Inicio Divicion Segunda Pantalla donde estan el menu y sus opciones -->
        <!-- Contenido de la segunda mitad de la pantalla -->
        <div class="mitad2">
            <!-- Inicio del Div del titulo, boton nueva cita y cuadro de busqueda -->
            <div class="contentpage" id="contentList">
                <div class="addntitle">
                    <h4 class="titulolist">
                        <img src="<?php echo URL;?>public_html/iconos/listado32.png" alt="x"/>
                        Listado de citas <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <!-- Boton Agregar Nueva Cita -->
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nueva Cita</span></button>             
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar una cita" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <div class="contentpageOP" id="contentListOP">
                <div class="addntitle">
                        <!-- Boton Ver citas de hoy -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('citas/getAllhoy')"><span class="opcionestxt">Citas Hoy</span></button>
                        <!-- Boton Ver citas de MA -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('citas/getCitasMA')"><span class="opcionestxt">Citas Mañana</span></button>
                        <!-- Boton Ver todas -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('citas/getCitasSemanaPendientes')"><span class="opcionestxt">Semana Pendientes</span></button> 
                        <!-- Boton Ver todas -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('citas/getAll')"><span class="opcionestxt">Todas</span></button>               
                    <hr>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->
            <section id="contenido">
                <!-- listado de citas -->
                <div id="contentList2">
                    <!-- Inicio de la tabla-->
                    <div class="contentT" id="contentTable">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID Cita</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Doctor</th>
                                <th class="estado">Estado</th>
                                <th>Editar - Eliminar</th>
                            </thead>
                            <tbody>
                                <td>1111</td>
                                <td>Nombre Paciente</td>
                                <td>Apellido Paciente</td>
                                <td>Descripcion sobre el paciente</td>
                                <td>05-05-2023</td>
                                <td>05:00:00</td>
                                <td>Nombre Doctor</td>
                                <td>Completado</td>
                                <td>
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
                                <li class="page-item"><a class="page-link" href="#">Anterior <img class="anteriorbtn" src="<?php echo URL;?>public_html/iconos/next.png" alt="x"/></a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Siguiente <img src="<?php echo URL;?>public_html/iconos/next.png" alt="x"/></a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Fin de paginacion -->
                </div>
                <!-- Fin del listado de citas -->
                
                <!--Incio de formulario de citas -->
                <div class="contact-form mt-3 d-none" id="contentForm">
                    <span class="agregartxt">Cita</span>
                    <form id="formCita" enctype="multipart/form-data">
                        <!-- ID oculto con valor de 0 -->
                        <input type="hidden" name="id_cita" id="id_cita" value="0">
                        
                        <label for="id_paciente">Nombre Paciente:</label>
                        <div class="selectform">
                            <select name="id_paciente" id="id_paciente" class="form-select">
                            </select>
                        </div>
                            
                        <label for="descripcion_cita">Descripción:</label>
                        <textarea id="descripcion_cita" name="descripcion_cita"></textarea>
                            
                            
                        <label for="fecha_cita">Fecha:</label>
                        <input type="date" id="fecha_cita" name="fecha_cita" required>

                        <label for="hora_cita">Seleccione una Hora:</label>
                        <div class="selectform">
                            <select name="hora_cita" id="hora_cita" class="form-select">
                                <option value="7:00 AM">7:00 AM</option>
                                <option value="7:30 AM">7:30 AM</option>
                                <option value="8:00 AM">8:00 AM</option>
                                <option value="8:30 AM">8:30 AM</option>
                                <option value="9:00 AM">9:00 AM</option>
                                <option value="9:30 AM">9:30 AM</option>
                                <option value="10:00 AM">10:00 AM</option>
                                <option value="10:30 AM">10:30 AM</option>
                                <option value="11:00 AM">11:00 AM</option>
                                <option value="11:30 AM">11:30 AM</option>
                                
                                <option value="1:00 PM">1:00 PM</option>
                                <option value="1:30 PM">1:30 PM</option>
                                <option value="2:00 PM">2:00 PM</option>
                                <option value="2:30 PM">2:30 PM</option>
                                <option value="3:00 PM">3:00 PM</option>
                                <option value="3:30 PM">3:30 PM</option>
                                <option value="4:00 PM">4:00 PM</option>
                                <option value="4:30 PM">4:30 PM</option>
                                <option value="5:00 PM">5:00 PM</option>
                                <option value="5:30 PM">5:30 PM</option>
                            </select>
                        </div>
                            
                        <label for="id_doctor">Doctor:</label>
                        <div class="selectform">
                            <select name="id_doctor" id="id_doctor" class="form-select">
                                
                            </select>
                        </div>

                        <label for="estado">Estado de la cita:</label>
                        <div class="selectform">
                            <select name="estado" id="estado" class="form-select">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Completada">Completada</option>
                                <option value="No Asistió">No Asistió</option>
                            </select>
                        </div>
                        <hr>
                        <div class="formbtn">
                            <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                            <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                        </div>
                    </form>
                </div>
                <!--Fin de formulario de citas -->
            </section>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/citas.js"></script>
</body>
</html>