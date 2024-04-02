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
    <title>Pago de Contado</title>
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
                <img class="imgGI" src="<?php echo URL;?>public_html/iconos/graficaingresos64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Ingresos Semana Pasada</h4>
            <h4 class="canthoynum" id="totalweek">0</h4>
            <h4 class="canthoytxt">Ingresos de Hoy</h4>
            <h4 class="canthoynum" id="totalhoy">0</h4>
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
                        Listado de Pagos Contados <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nuevo Pago Contado</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <div class="contentpageOP" id="contentListOP">
                <div class="addntitle">
                        <!-- Boton Ver Pago contados de semana pasada -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pagocontado/getSemana')"><span class="opcionestxt">Ingresos de la semana</span></button>
                        <!-- Boton Ver Pago contados de hoy -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pagocontado/getContadoHoy')"><span class="opcionestxt">Ingresos al contado hoy</span></button>
                        <!-- Boton Ver todas -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('pagocontado/getAll')"><span class="opcionestxt">Todas</span></button>             
                    <hr>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->
            <!-- listado -->
            <div id="contentList2">
                <!-- Inicio de la tabla-->
                    <div class="contentT" id="contentTable">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <th>Id Pago Contado</th> 
                                <th>Monto Contado</th>
                                <th>Fecha Pago</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Tratamiento</th>
                                <th>Editar - Eliminar</th>
                            </thead>
                            <tbody>
                                <td>1</td>
                                <td>500</td>
                                <td>1989-04-30</td>
                                <td>1</td>
                                <td>Brackets</td>
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
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
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
                <span class="agregartxt">Pago al contado</span>
                <form id="formPagocontado">
                    <input type="hidden" name="id_pagocontado" id="id_pagocontado" value="0">

                    <label for="monto_contado">Monto de contado:</label>
                    <input type="float" id="monto_contado" name="monto_contado" required>

                    <label for="fecha_pago">Fecha Pago:</label>
                    <input type="date" id="fecha_pago" name="fecha_pago" required>

                    <label for="id_paciente">Nombre Paciente:</label>
                    <div class="selectform">
                        <select name="id_paciente" id="id_paciente" class="form-select">
                        </select>
                    </div>

                    <label for="id_tratamiento">Tratamiento:</label>
                    <div class="selectform">
                        <select name="id_tratamiento" id="id_tratamiento" class="form-select">
                        </select>
                    </div>
                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                    </div>
                </form>
                <!--Fin de formulario -->
            </div>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/pagocontado.js"></script>
</body>
</html>
