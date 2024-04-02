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
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/perfiles.css">
    <!-- Icono en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Perfil</title>
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
    </div>
    <!-- Fin Divicion Pantalla Barra lateral -->

    <!-- Inicio Divicion Segunda Pantalla donde estan el menu y sus opciones -->
    <!-- Contenido de la segunda mitad de la pantalla -->
    <div class="mitad2">
      <!-- PERFIL -->
      <div class="infopa">
        <!-- Div Foto Info -->
        <div class="divfotoinfo">
          <div>
            <img src="<?php echo URL;?>public_html/iconos/profile64.png" alt="">
            <h4 class="infotitle">Perfil del Paciente</h4>
          </div>
          <hr>
          <div>
            <img src="<?php echo URL;?>public_html/iconos/idcard32.png" alt="">
            <label class="infotitle" for=""> Nombre del Paciente:</label>
            <span id="nombrepaciente" class="infotxt">Nombre Apellido</span>
          </div>

          <div>
            <label class="infotitle" for=""><img src="<?php echo URL;?>public_html/iconos/gender32.png" alt=""> Sexo</label>
            <span id="sexo" class="infotxt">Masculino</span>
          </div>

          <div>
            <img src="<?php echo URL;?>public_html/iconos/birth32.png" alt=""> 
            <label class="infotitle" for=""> Fecha de Nacimiento:</label>
            <span id="fechanacimiento" class="infotxt">22-02-2000</span>
          </div>
          
          <div>
            <img src="<?php echo URL;?>public_html/iconos/code32.png" alt=""> 
            <label class="infotitle" for=""> ID:</label>
            <span name="id_paciente" id="idpaciente" class="infotxt">200RC134</span>
          </div>
        </div>
        <!-- Fin Div Foto Info -->
        <!-- Inicio Datos del paciente -->
        <div class="divinfo">
          <h4 class="infotitle"><img src="<?php echo URL;?>public_html/iconos/informacion32.png" alt=""> Información del paciente</h4>
          <hr>
          <div>
            <label class="infotitle" for=""><img src="<?php echo URL;?>public_html/iconos/phonecall32.png" alt=""> Telefono</label>
            <span id="telefono" class="infotxt">0000 0000</span>
          </div>

          <div>
            <label class="infotitle" for=""><img src="<?php echo URL;?>public_html/iconos/find32.png" alt=""> Observación</label>
            <span id="observacion"class="infotxt">Ninguna</span>
          </div>

          <div>
            <label class="infotitle" for=""><img src="<?php echo URL;?>public_html/iconos/alergia32.png" alt=""> Alergia</label>
            <span id="alergia" class="infotxt">Ninguna</span>
          </div>

          <div>
            <label class="infotitle" for=""><img src="<?php echo URL;?>public_html/iconos/padecimiento32.png" alt=""> Padecimiento</label>
            <span id="padecimiento" class="infotxt">Ninguna</span>
          </div>
        </div>
        <div class="opcionespago">
          
          
        </div>
      </div>
      <!-- Fin Datos del paciente -->

      <!-- Opciones de pago -->
      <div class="divopciones">
        
      </div>
    </div>
  </div>
  <script>
    <?php 
    echo "const idperfil={$_GET["id"]};\n";
    ?>
  </script>
  <?php include_once "app/views/sections/scripts.php"; ?>
  <script src="<?php echo URL;?>public_html/customjs/perfiles.js"></script>
</body>
</html>