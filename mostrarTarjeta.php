<?php
require 'includes/funciones.php';
incluirTemplate('header');

// Iniciar sesión para recuperar los datos
session_start();

// Verificar si hay datos de tarjeta guardados
if (!isset($_SESSION['tarjeta'])) {
    header('Location: tarjeta.php');
    exit;
}

// Recuperar los datos
$tarjeta = $_SESSION['tarjeta'];
?>

<section class="seccion contenedor">
    <div class="alerta exito">
        <p>¡Tarjeta creada exitosamente!</p>
    </div>

    <div class="tarjeta-contenedor">
        <div class="tarjeta-presentacion">
            <div class="tarjeta-header">
                <img src="<?php echo $tarjeta['imagen']; ?>" alt="Fotografía" class="tarjeta-imagen">
                <div class="tarjeta-info">
                    <h2><?php echo $tarjeta['nombre'] . ' ' . $tarjeta['apellido_paterno'] . ' ' . $tarjeta['apellido_materno']; ?></h2>
                    <p class="puesto"><?php echo $tarjeta['puesto']; ?></p>
                </div>
            </div>

            <div class="tarjeta-detalles">
                <div class="tarjeta-contacto">
                    <div class="contacto-item">
                        <span class="icono">📱</span>
                        <span><?php echo $tarjeta['telefono']; ?></span>
                    </div>

                    <div class="contacto-item">
                        <span class="icono">✉️</span>
                        <span><?php echo $tarjeta['email']; ?></span>
                    </div>
                </div>

                <div class="tarjeta-qr">
                    <!-- Aquí se puede generar un código QR con los datos de contacto -->
                    <div class="qr-placeholder">
                        <p>Escanea para guardar contacto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="botones-accion">
        <a href="tarjeta.php" class="boton">Crear Nueva Tarjeta</a>
        <button onclick="window.print()" class="boton boton-verde">Imprimir Tarjeta</button>
    </div>
</section>

</body>

</html>