<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Referencias de CSS variables-->
    <!-- CSS del login -->
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/loginform.css">
    <!-- CSS del fondo -->
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/fondologin.css">
    <!-- CSS del los fonts -->
    <link rel="stylesheet" href="<?php echo URL;?>public_html/css/fonts.css">
    <!-- Icono del sistema en el navegador -->
    <link rel="shortcut icon" href="<?php echo URL;?>public_html/iconos/logonav.png" type="image/x-icon">
    <title>Clinica Dental Integral</title>
</head>
<body>
    <!-- Inicio del Section -->
    <section>
        <div class="box">
            <div class="form">
                <!-- Logo -->
                <img class="logologin" src="<?php echo URL;?>public_html/images/logodiente.png" alt="logo">
                <!-- Titulo --> 
                <h2>Clinica Dental Integral</h2>
                <!-- Inicio del Form del Login -->
                <form action="login.php" id="formlogin">
                    <!-- Input del usuario -->
                    <div class="inputBox">
                        <input name="usuario" type="text" required="required">
                        <span>Usuario</span>
                        <i></i>
                    </div>
                    <!-- Input del password -->
                    <div class="inputBox">
                        <input name="password" type="password" required="required">
                        <span>Contraseña</span>
                        <i></i>
                    </div>
                    <!-- Mensaje de alerta si el usuario y password son incorrectos -->
                    <div class="alert alert-danger mt-5 d-none" role="alert" id="mensaje">
                    </div>
                    <!-- Boton para iniciar sesion -->
                    <button class="c" type="submit">Iniciar Sesión</button>
                </form>
                <!-- Fin del Form del Login -->
                <br>
                <br>
            </div>
        </div>
    </section>
    <!-- Fin del Section -->
    <!-- Pie de pagina -->
    <footer>
        <p>Clínica Dental Integral &copy;</p>
    </footer>
    <!-- Scripts -->
    <script src="<?php echo URL; ?>public_html/customjs/api.js"></script>
    <script src="<?php echo URL; ?>public_html/customjs/login.js"></script>
</body>
</html>