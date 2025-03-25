<?php
require 'includes/funciones.php';
incluirTemplate('header');

// En una aplicación real, buscaríamos la información de la tarjeta en la base de datos usando el ID
$id_tarjeta = isset($_GET['id']) ? $_GET['id'] : null;

// Como no tenemos base de datos, usaremos datos ficticios para demostración
$tarjeta = [
    'nombre' => 'Nombre del Usuario',
    'apellido_paterno' => 'Apellido Paterno',
    'apellido_materno' => 'Apellido Materno',
    'puesto' => 'Puesto del Usuario',
    'telefono' => '5551234567',
    'email' => 'usuario@ejemplo.com',
    'imagen' => 'imagenes/default.jpg' // Imagen por defecto
];

// En una aplicación real, verificaríamos si existe la tarjeta con ese ID
$existeTarjeta = true;

// Si existe el ID, buscaríamos los datos reales de la tarjeta
if ($id_tarjeta && $existeTarjeta) {
    // Aquí se cargarían los datos reales de la base de datos
    // Ejemplo (simulado):
    // $query = "SELECT * FROM tarjetas WHERE id_tarjeta = ?";
    // Ejecutar query y obtener datos...
}
?>

<section class="seccion contenedor">
    <?php if ($existeTarjeta): ?>
        <h1>Tarjeta de Presentación</h1>

        <div class="tarjeta-presentacion">
            <div class="tarjeta-header">
                <img src="<?php echo $tarjeta['imagen']; ?>" alt="Foto de perfil" class="tarjeta-imagen">
                <div class="tarjeta-info">
                    <h2><?php echo $tarjeta['nombre'] . ' ' . $tarjeta['apellido_paterno'] . ' ' . $tarjeta['apellido_materno']; ?></h2>
                    <p class="puesto"><?php echo $tarjeta['puesto']; ?></p>
                </div>
            </div>
            <div class="tarjeta-contacto">
                <p><strong>Teléfono:</strong> <?php echo $tarjeta['telefono']; ?></p>
                <p><strong>Email:</strong> <?php echo $tarjeta['email']; ?></p>
            </div>
            <div class="tarjeta-qr">
                <!-- Aquí podría ir un código QR generado -->
                <p>Escanea para guardar contacto</p>
            </div>
        </div>

        <div class="botones-accion">
            <a href="tarjeta.php" class="boton">Crear Nueva Tarjeta</a>
            <button onclick="window.print()" class="boton boton-verde">Imprimir Tarjeta</button>
        </div>
    <?php else: ?>
        <div class="alerta error">
            <p>No se encontró la tarjeta solicitada</p>
        </div>
        <div class="botones-accion">
            <a href="tarjeta.php" class="boton">Crear Nueva Tarjeta</a>
        </div>
    <?php endif; ?>
</section>

</body>

</html>