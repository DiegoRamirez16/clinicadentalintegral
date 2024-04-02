<!-- Menu de navegacion general -->
<div class="menug">
    <!-- Logo -->
    <div class="logomenu">
        <img class="logom" src="<?php echo URL;?>public_html/images/logodiente.png">
        <a class="namelogo" href="<?php echo URL;?>dashboard">Clínica Dental Integral</a>
    </div>
    <!-- Opciones del menu -->
    <div class="opciones">
        <div class="dropdown">
            <!-- Servicios -->
            <div class="dropdownservicios">
                <button class="serviciosbtn">Servicios <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentservicios">
                    <a href="<?php echo URL;?>pacientes">Pacientes</a>
                    <a href="<?php echo URL;?>citas">Citas</a>   
                    <a href="<?php echo URL;?>expedientes">Expedientes</a>
                    <a href="<?php echo URL;?>tratamientos">Tratamientos</a>
                </div>
            </div>
            <!-- Ayuda -->
            <div class="dropdownsoporte">
                <button class="soportebtn">Soporte <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentsoporte">
                    <a onclick="abrirManual()">Manual de Usuario</a>
                    <a href="<?php echo URL;?>informaciones"><img src="<?php echo URL;?>public_html/iconos/info24.png" alt="x"/> Información</a>
                </div>
            </div>
            <!-- Cerrar Sesion -->
            <div class="dropdownsalir">
                <button class="salirbtn">Salir <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentsalir">
                    <a href="<?php echo URL;?>login/cerrar" tabindex="-1" aria-disabled="true">Cerrar sesion</a>
                </div>
            </div>
        </div>
    </div>
</div>