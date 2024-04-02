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
    <title>Clinica Dental Integral</title>
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

        <!-- Todos los elementos que varian-->
        <div class="mitad2">
            <!-- Inicio del Div del titulo -->
            <div class="contentpage" id="contentList">
                <div class="addntitle">
                    <h4 class="titulolist">
                        <img src="<?php echo URL;?>public_html/iconos/listado32.png" alt="x"/>
                        Reporte de Pagos al Contado
                    </h4>
                    <hr>
                </div>
                
            </div>
            <!-- Fin del Div del titulo -->
            <!-- Inicio Opciones para ver el reporte -->
            <div class="contact-form mt-3">
                <div>
                    <label for="autoSizingInput">Fecha Pago:</label>
                    <div class="selectform">
                        <select name="id_pagocontado" id="id_pagocontado" class="form-select">

                        </select>
                    </div>       
                </div>
                <div>
                    <label for="autoSizingInput">Paciente:</label>
                    <div class="selectform">
                        <select name="id_paciente" id="id_paciente" class="form-select">

                        </select>
                    </div>       
                </div>
                <div class="formbtn">
                    <button class="reportebtn" type="button" id="btnViewReport"><img src="<?php echo URL;?>public_html/iconos/print24.png" alt="x"/> Ver Reporte</button>
                </div>
            </div>
            <!-- Fin Opciones para ver el reporte -->
            <div class="row">
                <iframe src="" frameborder="0" width="100%" height="800" id="framereporte"></iframe>
            </div>
        </div>
    </div>
    <?php include_once "app/views/sections/scripts.php"; ?>
    <script src="<?php echo URL;?>public_html/customjs/reporteingresos.js"></script>
</body>
</html>