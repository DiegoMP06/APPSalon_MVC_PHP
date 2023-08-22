<h1 class="nombre pagina">Crear Servicio</h1>
<p class="descripcion-pagina">Llena Todos los Campos para Añadir un Nuevo Servicio.</p>

<?php include_once __DIR__ . "/../templates/barra.php"; ?>

<form action="/servicios/crear" method="post" class="formularic">
    <?php include __DIR__ . "/formulario.php"; ?>
    <input type="submit" value="Crear Servicio" class="boton">
</form>