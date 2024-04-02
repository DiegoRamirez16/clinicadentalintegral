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
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/informaciones.css">
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
        <hr class="line1">
            <!-- Cantidad de citas para hoy -->
            <div class="cantdiv">
                <img class="imgGI" src="<?php echo URL;?>public_html/iconos/version64.png" alt="x"/>
                
            </div>
            <h4 class="canthoytxt">Version del Sistema</h4>
            <h4 class="canthoynum">v1.0</h4>
    </div>
    <!-- Fin Divicion Pantalla Barra lateral -->

    <!-- Inicio Divicion Segunda Pantalla donde estan el menu y sus opciones -->
    <!-- Contenido de la segunda mitad de la pantalla -->
    <div class="mitad2">
        <div class="infotop1">
            <hr>
            <!-- Mensaje de bienvenida -->
            <h3><b><center>Sistema de Información de la Clinica Dental Integral</b></h3>
            <!-- Logo en el menu principal -->
            <div style="text-align: center;">
                <img class="logodash" src="public_html/images/logodiente.png">

                <img class="logodash" src="public_html/images/unicaeslogo.png">
            </div>
            <!-- Descripcion -->
            <p class="descriptxt">Información General</p>
            <hr>
        </div>
        <div class="infotop2">
            <h3><center>Sistema de Información de control de citas e ingresos semanales</h3>
            <h3><center>a fin de agilizar los procesos de la “Clínica Dental Integral”</h3>
            <hr>
            <p class="descriptxt">
                La implementación de este sistema de información fue realizado en conjunto con estudiantes de la Universidad Católica de El Salvador<br>
                como parte del proceso academico de la carrera Licenciatura en Sistemas Informaticos Administrativos<br>

                <br>Contactos de soporte
            </p>
        </div>
        <div class="contactos">
            <!-- Perfil -->
            <div class="card-client">
                <div class="user-picture">
                    <img src="<?php echo URL;?>public_html/iconos/contactos64.png" alt="">
                </div>
                <p class="name-client"> Carlos Francisco
                    <span>Ruiz Cortez</span>
                </p>
                <div class="social-media">       
                <span class="tooltipsocial">carlos.ruiz4@catolica.edu.sv</span>
                </div>
            </div>
            <!-- Fin Perfil -->
            <!-- Perfil -->
            <div class="card-client">
                <div class="user-picture">
                    <img src="<?php echo URL;?>public_html/iconos/contactos64.png" alt="">
                </div>
                <p class="name-client"> Diego Ernesto
                    <span>Ramirez Rivera</span>
                </p>
                <div class="social-media">       
                <span class="tooltipsocial">diego.ramirez@catolica.edu.sv</span>
                </div>
            </div>
            <!-- Fin Perfil -->
            <!-- Perfil -->
            <div class="card-client">
                <div class="user-picture">
                    <img src="<?php echo URL;?>public_html/iconos/contactos64.png" alt="">
                </div>
                <p class="name-client"> Erick Alfonso
                    <span>Paredes Rivas</span>
                </p>
                <div class="social-media">       
                <span class="tooltipsocial">erick.paredes@catolica.edu.sv</span>
                </div>
            </div>
            <!-- Fin Perfil -->
            
        </div>
    </div>
</body>
</html>
