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
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/calculadora.css">
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Plan Cuotas</title>
</head>
<body>
    <div class="contenedor">
        <!-- Menu de navegacion -->
        <section id="menu">
            <?php include_once "app/views/sections/menugeneral.php"; ?>
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
            <!-- Calculadora -->
            <div class="cantdiv">
                <img class="imgcalendar" src="<?php echo URL;?>public_html/iconos/calculadora64.png" alt="x"/>
            </div>
            <div class="divcal">
                <h4 class="canthoytxt">Calcular Cuota</h4>
                <label class="caltxt" for="monto">Monto Total $</label>
                <input class="inputcal" placeholder="Ingrese total a pagar" type="number" id="monto">
                <label class="caltxt" for="">Cant. Cuotas</label>
                <input class="inputcal" placeholder="Cantidad de cuotas" type="number" id="cantcuotas">
                <button class="btncal" onclick="calcularDivision()">Calcular</button>
                <h4 class="canthoynum" id="resultado">$</h4>
            </div>
            <hr class="line1">
            <!-- Cantidad de citas para hoy -->
            <div class="cantdiv">
                <img class="imgGI" src="<?php echo URL;?>public_html/iconos/graficaingresos64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Ingresos Hoy</h4>
            <h4 class="canthoynum" id="totalcuotashoy">0</h4>
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
                        <h1>Cuotas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="contentList2">
                            <!-- Inicio de la tabla-->
                            <div class="contentT" id="contentTableC">
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <th>ID Cuota</th>
                                        <th>Fecha</th>
                                        <th>Cuota</th>
                                        <th>Monto a pagar</th>
                                        <th>ID Plan Cuota</th>
                                        <th>Estado</th>
                                        <th>Pagar - Eliminar</th>
                                    </thead>
                                    <tbody>
                                        <td>1</td>
                                        <td>NameTrat</td>
                                        <td>13-23-2022</td>
                                        <td>Listo</td>
                                        <td>Paciente bien</td>
                                        <td>Name</td>
                                        <td>
                                            <button class="editarbtn" type="button"><img src="<?php echo URL;?>public_html/iconos/credit-card.png" alt="x"/></button>
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
                        <!--Incio del formulario -->
                        <div id="contentFormC" class="contact-form mt-3 d-none">
                            <span class="agregartxt">Cuotas</span>
                            <form id="formCuota">
                                <input type="hidden" name="id_cuota" id="id_cuota" value="0">

                                <label for="fecha_pago">Fecha de Pago:</label>
                                <input type="date" id="fecha_pago" name="fecha_pago">

                                <label for="cuota">Cuota:</label>
                                <input type="number" id="cuota" name="cuota" required>

                                <label for="monto_cuota">Monto:</label>
                                <input type="float" id="monto_cuota" name="monto_cuota" required>

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
                                    <button class="savebtn" type="submit" id="btnAgregarCuota">Guardar</button>
                                    <button class="savebtn d-none" type="submit" id="btnGuardarCambios">Guardar Cambios</button>
                                    <button class="cancelbtn" type="button" id="btnCancelarC" onclick="cancelarCuota">Cancelar</button>
                                </div>
                            </form>
                            <!-- Fin del formulario -->
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btncerrar" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--Fin modal-->
            <!-- Inicio del Div del titulo, boton nueva cita y cuadro de busqueda -->
            <div class="contentpage" id="contentListMenu">
                <div class="addntitle">
                    <h4 class="titulolist">
                        <img src="<?php echo URL;?>public_html/iconos/listado32.png" alt="x"/>
                        Listado de Planes de Cuotas <img src="<?php echo URL;?>public_html/iconos/flechaderecha.png" alt="x"/>
                        <!-- Boton Agregar Nueva Cita -->
                        <button class="addbtn" type="button" id="btnAgregar"><span class="addtxt">Nuevo Plan de Cuota</span></button>
                    </h4>
                    <hr>
                </div>
                <div class="searchbox">
                    <input class="searchinput" type="search" placeholder="Buscar una plan" name="text" class="input" id="txtSearch">
                    <img class="imgsearch" src="<?php echo URL;?>public_html/iconos/lupa.png" alt="x"/>
                </div>
            </div>
            <div class="contentpageOP" id="contentListOP">
                <div class="addntitle">
                        <!-- Boton Ver citas de hoy -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('plandepagos/getPlanesActivos')"><span class="opcionestxt">Planes Activos</span></button>
                        <!-- Boton Ver citas de MA -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('plandepagos/getPlanesInactivos')"><span class="opcionestxt">Planes Inactivos</span></button>
                        <!-- Boton Ver todas -->
                        <button class="opcionesbtn" type="button" onclick="cambiarApi('plandepagos/getAll')"><span class="opcionestxt">Todos</span></button>                
                    <hr>
                </div>
            </div>
            <!-- Fin del Div del titulo, boton nueva cita y cuadro de busqueda -->

            <!-- listado de plan de pagos -->
            <div id="contentList">
                <!-- Inicio de la tabla-->
                <div class="contentT" id="contentTable">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <th>ID Plan Cuota</th>
                            <th>Paciente</th>
                            <th>Monto</th>
                            <th>Cantidad cuotas</th>
                            <th>Fecha plan pago</th>
                            <th>Estado</th>
                            <th>Tratamiento</th>
                            <th>Cuotas-Editar-Eliminar</th>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>2</td>
                            <td>500</td>
                            <td>12</td>
                            <td>12-06-2022</td>
                            <td>Activo</td>
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
            <!-- Fin del listado de planes de pago -->
            <!--Incio de formulario de planes de pago -->
            <div id="contentForm" class="contact-form mt-3 d-none">
                <span class="agregartxt">Planes de Cuota</span>
                <form id="formPago" enctype="multipart/form-data">
                    <!-- ID oculto con valor de 0 -->
                    <input type="hidden" name="id_plancuota" id="id_plancuota" value="0">

                    <label for="id_paciente">Nombre Paciente:</label>
                    <div class="selectform">
                        <select name="id_paciente" id="id_paciente" class="form-select">
                        </select>
                    </div>

                    <label for="monto">Monto:</label>
                    <input type="float" id="monto" name="monto" required>

                    <label for="cantidad_cuotas">Cantidad Cuotas:</label>
                    <input type="number" id="cantidad_cuotas" name="cantidad_cuotas" required>

                    <label for="fecha_planpago">Fecha:</label>
                    <input type="date" id="fecha_plancuota" name="fecha_plancuota" required>

                    <label for="estado">Estado del Plan:</label>
                    <div class="selectform">
                        <select name="estado" id="estado" class="form-select">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
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
                <!--Fin del formulario -->
            </div>
            <!--Incio de formulario cambios de planes de pago -->
            <div id="contentFormPlancambios" class="contact-form mt-3 d-none">
                <span class="agregartxt">Planes de Cuota</span>
                <form id="formPlancambios" enctype="multipart/form-data">
                    <!-- ID oculto con valor de 0 -->
                    <input type="hidden" name="id_plancuotac" id="id_plancuotac" value="0">

                    <label for="id_paciente">Nombre Paciente:</label>
                    <div class="selectform">
                        <select name="id_pacientec" id="id_pacientec" class="form-select">
                        </select>
                    </div>

                    <label for="monto">Monto:</label>
                    <input type="number" id="montoc" name="montoc" required>

                    <label for="cantidad_cuotas">Cantidad Cuotas:</label>
                    <input type="number" id="cantidad_cuotasc" name="cantidad_cuotasc" required>

                    <label for="fecha_planpago">Fecha:</label>
                    <input type="date" id="fecha_plancuotac" name="fecha_plancuotac" required>

                    <label for="estado">Estado del plan:</label>
                    <div class="selectform">
                        <select name="estadoc" id="estadoc" class="form-select">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <label for="id_tratamiento">Tratamiento:</label>
                    <div class="selectform">
                        <select name="id_tratamientoc" id="id_tratamientoc" class="form-select">
                        </select>
                    </div>

                    <div class="formbtn">
                        <button class="savebtn" type="submit" id="btnAgregar">Guardar</button>
                        <button class="cancelbtn" type="button" id="btnCancelarCambios">Cancelar</button>
                    </div>
                </form>
                <!--Fin del formulario -->
            </div>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/plandepagos.js"></script>
</body>
</html>

