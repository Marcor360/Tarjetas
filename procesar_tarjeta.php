<?php
// Activar reporte de errores para desarrollo (puedes quitar esto en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'includes/funciones.php';
incluirTemplate('header');

// Variables para controlar el estado
$errores = [];
$exito = false;
$datos_tarjeta = null;

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $apellido_paterno = $_POST['apellido_paterno'] ?? '';
    $apellido_materno = $_POST['apellido_materno'] ?? '';
    $puesto = $_POST['puesto'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validaciones básicas
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    }
    if (empty($apellido_paterno)) {
        $errores[] = "El apellido paterno es obligatorio";
    }
    if (empty($apellido_materno)) {
        $errores[] = "El apellido materno es obligatorio";
    }
    if (empty($puesto)) {
        $errores[] = "El puesto es obligatorio";
    }
    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio";
    }
    if (empty($fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria";
    }
    if (empty($email)) {
        $errores[] = "El correo electrónico es obligatorio";
    }

    // Procesar la imagen
    $ruta_imagen = 'https://via.placeholder.com/150';

    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
        // Verificar tipo de archivo
        $tipo_archivo = $_FILES['fotografia']['type'];
        if ($tipo_archivo == 'image/jpeg' || $tipo_archivo == 'image/png' || $tipo_archivo == 'image/gif') {
            // Procesar imagen
            $carpeta_destino = "imagenes/";

            // Crear la carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }

            // Generar nombre único para el archivo
            $nombre_archivo = uniqid() . "_" . $_FILES['fotografia']['name'];
            $ruta_completa = $carpeta_destino . $nombre_archivo;

            // Mover el archivo
            if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $ruta_completa)) {
                $ruta_imagen = $ruta_completa;
            }
        }
    }

    // Si no hay errores, preparar para mostrar la tarjeta
    if (empty($errores)) {
        $exito = true;
        $datos_tarjeta = [
            'nombre' => $nombre,
            'apellido_paterno' => $apellido_paterno,
            'apellido_materno' => $apellido_materno,
            'puesto' => $puesto,
            'telefono' => $telefono,
            'fecha_nacimiento' => $fecha_nacimiento,
            'email' => $email,
            'imagen' => $ruta_imagen
        ];
    }
}
?>

<section class="seccion contenedor">
    <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <div class="alerta error">
            <p>No se ha enviado ningún formulario</p>
        </div>
        <div class="botones-accion">
            <a href="tarjeta.php" class="boton">Ir al formulario</a>
        </div>
    <?php elseif (!empty($errores)): ?>
        <div class="alerta error">
            <p>Por favor, corrige los siguientes errores:</p>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="botones-accion">
            <a href="javascript:history.back()" class="boton">Volver al formulario</a>
        </div>
    <?php elseif ($exito): ?>
        <div class="alerta exito">
            <p>¡Tarjeta generada con éxito!</p>
        </div>

        <div class="tarjeta-presentacion">
            <!-- Añadir el logo -->
            <picture>
                <source src="build/img/Logo.webp" type="image/webp">
                <img loading="lazy" src="build/img/Logo.png" alt="Logo de la empresa" class="tarjeta-logo">
            </picture>

            <div class="tarjeta-header">
                <img src="<?php echo $datos_tarjeta['imagen']; ?>" alt="Foto de perfil" class="tarjeta-imagen">
                <div class="tarjeta-info">
                    <h2><?php echo $datos_tarjeta['nombre'] . ' ' . $datos_tarjeta['apellido_paterno'] . ' ' . $datos_tarjeta['apellido_materno']; ?></h2>
                    <p class="puesto"><?php echo $datos_tarjeta['puesto']; ?></p>
                </div>
            </div>

            <div class="tarjeta-contacto">
                <p><strong>Teléfono:</strong> <?php echo $datos_tarjeta['telefono']; ?></p>
                <p><strong>Email:</strong> <?php echo $datos_tarjeta['email']; ?></p>
                <p><strong>Fecha de nacimiento:</strong> <?php echo $datos_tarjeta['fecha_nacimiento']; ?></p>
            </div>
        </div>

        <div class="botones-accion">
            <a href="tarjeta.php" class="boton">Crear nueva tarjeta</a>
            <button onclick="window.print()" class="boton boton-verde">Imprimir tarjeta</button>
        </div>
    <?php endif; ?>
</section>

</body>

</html>