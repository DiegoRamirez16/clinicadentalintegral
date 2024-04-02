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
                    
                </div>
            </div>
            <!-- Ingresos -->
            <div class="dropdowningresos">
                <button class="ingresosbtn">Ingresos <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentingresos">
                    <a href="<?php echo URL;?>pagocontado">Pago Contados</a>
                    <a href="<?php echo URL;?>plandepagos">Planes de Cuotas</a>
                </div>
            </div>
            <!-- Administracion -->
            <div class="dropdownadmin">
                <button class="adminbtn">Administración <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentadmin">
                    <a href="<?php echo URL;?>doctores">Doctores</a>
                    <a href="<?php echo URL;?>tratamientos">Tratamientos</a>
                </div>
            </div>
            <!-- Reportes -->
            <div class="dropdownreportes">
                <button class="reportesbtn">Reportes <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentreportes">
                    <a href="<?php echo URL;?>reportecitas">Reporte Citas</a>
                    <a href="<?php echo URL;?>reporteexpedientes">Reporte Expediente</a>
                    <a href="<?php echo URL;?>reportecontroles">Reporte Controles</a>
                    <a href="<?php echo URL;?>reporteingresos">Reporte de ingresos al contado</a>
                    <a href="<?php echo URL;?>reportecuotas">Reporte de Pagos de cuotas</a>
                </div>
            </div>
            <!-- Soporte -->
            <div class="dropdownsoporte">
                <button class="soportebtn">Soporte <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentsoporte">
                    <a href="" onclick="abrirManual()">Manual de Usuario</a>
                    <a href="<?php echo URL;?>informaciones"><img src="<?php echo URL;?>public_html/iconos/info24.png" alt="x"/> Información</a>
                </div>
            </div>
            <!-- Cerrar Sesion -->
            <div class="dropdownsalir">
                <button class="salirbtn">Salir <img src="<?php echo URL;?>public_html/iconos/arrowdown.png" alt="x"/></button>
                <div class="contentsalir">
                    <a href="<?php echo URL;?>login/cerrar" tabindex="-1" aria-disabled="true"><img src="<?php echo URL;?>public_html/iconos/log-out.png" alt="x"/> Cerrar sesion</a>
                </div>
            </div>
        </div>
    </div>
</div>