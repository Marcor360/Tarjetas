<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<section class="formu">
    <h1>Formulario de relleno de tarjeta</h1>
    <div class="contenedor">
        <form action="procesar_tarjeta.php" method="POST" class="formulario" enctype="multipart/form-data">
            <h2>Crear Tarjeta de Presentación</h2>

            <label for="nombre">Nombres:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan">

            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" required placeholder="Ej. Perez">

            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" required placeholder="Ej. Lopez">

            <label for="puesto">Puesto:</label>
            <input type="text" id="puesto" name="puesto" required placeholder="Ej. Encargado de Marketing">

            <label for="telefono">Número Telefónico:</label>
            <input type="tel" id="telefono" name="telefono" required pattern="[0-9]{10}" placeholder="Ej. 5551234567">

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required placeholder="Ej. 1990-01-01">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Ej. juanperezlopez@hangten.com">

            <label for="fotografia">Fotografía:</label>
            <input type="file" id="fotografia" name="fotografia" accept="image/*" required>

            <button type="submit">Generar Tarjeta</button>
        </form>
    </div>
</section>
</body>

</html>