<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS fijos -->
    <?php include_once "app/views/sections/css.php"; ?>
    <!-- CSS propios -->
    <!-- CSS propio del Dashboard Menu Principal -->
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/dashboard.css">
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Clinica Dental Integral</title>
</head>
<body>
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
        <hr>
        <!-- Mensaje de bienvenida -->
        <h3><b><center>¡Bienvenidos al Sistema de Información!</b></h3>
        <!-- Logo en el menu principal -->
        <div style="text-align: center;">
            <img class="logodash" src="public_html/images/logodiente.png">
        </div>
        <!-- Descripcion -->
        <p class="descriptxt">Menu Principal</p>
        <hr>
        <!-- Primera Columna de opciones del menu donde estan los cards -->
        <div class="row mt-4 d-flex justify-content-around">
            <!-- Opcion citas-->
            <div class="card">
                <!-- icono del card citas -->
                <div class="card-img">
                    <a href="<?php echo URL;?>citas">
                        <img src="public_html/images/calendario.png" class="card-img-top" alt="...">
                    </a>
                </div>
                <div class="card-info">
                    <!-- Texto del card citas -->
                    <div class="card-text">
                        <p class="text-title"></p>
                        <p class="text-subtitle">Citas</p>
                    </div>
                    <!-- icono flecha en formato SVG del card citas -->
                    <div class="card-icon">
                        <a href="<?php echo URL;?>citas">
                            <svg viewBox="0 0 28 25">
                                <path d="M13.145 2.13l1.94-1.867 12.178 12-12.178 12-1.94-1.867 8.931-8.8H.737V10.93h21.339z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Opcion Pacientes-->
            <div class="card">
                <!-- icono del card pacientes -->
                <div class="card-img">
                    <a href="<?php echo URL;?>pacientes">
                        <img src="public_html/images/dental.png" class="card-img-top" alt="...">
                    </a>
                </div>
                <div class="card-info">
                    <!-- Texto del card pacientes -->
                    <div class="card-text">
                        <p class="text-title"></p>
                        <p class="text-subtitle">Pacientes</p>
                    </div>
                    <!-- icono flecha en formato SVG del card pacientes -->
                    <div class="card-icon">
                        <a href="<?php echo URL;?>pacientes">
                            <svg viewBox="0 0 28 25">
                                <path d="M13.145 2.13l1.94-1.867 12.178 12-12.178 12-1.94-1.867 8.931-8.8H.737V10.93h21.339z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Opcion Expediente -->
            <div class="card">
                <!-- icono del card expedientes -->
                <div class="card-img">
                    <a href="<?php echo URL;?>expedientes">
                        <img src="public_html/images/expediente.png" class="card-img-top" alt="...">
                    </a>
                </div>
                <!-- Texto del card pacientes -->
                <div class="card-info">
                    <div class="card-text">
                        <p class="text-title"></p>
                        <p class="text-subtitle">Expediente</p>
                    </div>
                    <!-- icono flecha en formato SVG del card pacientes -->
                    <div class="card-icon">
                        <a href="<?php echo URL;?>expedientes">
                            <svg viewBox="0 0 28 25">
                                <path d="M13.145 2.13l1.94-1.867 12.178 12-12.178 12-1.94-1.867 8.931-8.8H.737V10.93h21.339z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Final Columna 1-->
        <!-- Segunda Columna de opciones del menu donde estan los cards -->
        <div class="row mt-4 d-flex justify-content-around">
            <!-- Opcion Tratamientos-->
            <div class="card">
                <!-- icono del card tratamientos -->
                <div class="card-img">
                    <a href="<?php echo URL;?>tratamientos">
                        <img src="public_html/images/tratamientos.png" class="card-img-top" alt="...">
                    </a>
                </div>
                <!-- Texto del card tratamientos -->
                <div class="card-info">
                    <div class="card-text">
                        <p class="text-title"></p>
                        <p class="text-subtitle">Tratamientos</p>
                    </div>
                    <!-- icono flecha en formato SVG del card expedientes -->
                    <div class="card-icon">
                        <a href="<?php echo URL;?>tratamientos">
                            <svg viewBox="0 0 28 25">
                                <path d="M13.145 2.13l1.94-1.867 12.178 12-12.178 12-1.94-1.867 8.931-8.8H.737V10.93h21.339z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Opcion Informacion  -->
            <div class="card">
                <!-- icono del card Informacion -->
                <div class="card-img">
                    <a href="<?php echo URL;?>informaciones">
                        <img src="public_html/images/controles.png" class="card-img-top" alt="...">
                    </a>
                </div>
                <!-- Texto del card Informacion -->
                <div class="card-info">
                    <div class="card-text">
                        <p class="text-title"></p>
                        <p class="text-subtitle">Información</p>
                    </div>
                    <!-- icono flecha en formato SVG del card expedientes -->
                    <div class="card-icon">
                        <a href="<?php echo URL;?>informaciones">
                            <svg viewBox="0 0 28 25">
                                <path d="M13.145 2.13l1.94-1.867 12.178 12-12.178 12-1.94-1.867 8.931-8.8H.737V10.93h21.339z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN de la segunda coloumna de opciones -->
    </div>
    <!-- Scripts -->
    <?php include_once "app/views/sections/scripts.php"; ?>
</body>
</html>
