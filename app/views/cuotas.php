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
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Detalle Cuotas</title>
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
                        Listado de Cuotas <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nueva Cuota</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar cuota" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->

            <!-- listado de cuotas -->
            <div id="contentList2">
                <!-- Inicio de la tabla-->
                <div id="contentTable">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <th>ID Cuota</th>
                            <th>Plan Cuota</th>
                            <th>Numero de Cuota</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <td>1234</td>
                            <td>10</td>
                            <td>1</td>
                            <td>25</td>
                            <td>2022-12-13</td>
                            <td>Pendiente Pago</td>
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
            <!--Incio del formulario -->
            <div id="contentForm" class="contact-form mt-3 d-none">
                <span class="agregartxt">Cuotas</span>
                <form id="formCuota">
                    <input type="hidden" name="id_cuota" id="id_cuota" value="0">

                    <label for="fecha_pago">Fecha de Pago:</label>
                    <input type="date" id="fecha_pago" name="fecha_pago">

                    <label for="cuota">Cuota:</label>
                    <input type="number" id="cuota" name="cuota" required>

                    <label for="monto_cuota">Monto:</label>
                    <input type="number" id="monto_cuota" name="monto_cuota" required>

                    <label for="id_planpago">ID Plan Cuota:</label>
                    <input type="number" id="id_plancuota" name="id_plancuota" required>

                    <label for="estado">Estado:</label>
                    <div class="selectform">
                        <select name="estado" id="estado" class="form-select">
                            <option value="Pagado">Pagado</option>
                            <option value="Pago pendiente">Pago pendiente</option>
                        </select>
                    </div>
                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="cancelbtn" type="button" id="btnCancelar">Cancelar</button>
                    </div>
                </form>
                <!-- Fin del formulario -->
            </div>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/cuotas.js"></script>
</body>
</html>