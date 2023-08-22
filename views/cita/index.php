<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus Servicios y Coloca tus Datos.</p>

<?php include __DIR__ . "/../templates/barra.php" ?>

<div class="app">
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus Servicios a Continuacion.</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus Datos y Fecha de tu Cita.</p>

        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre ?>"
                    disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha: </label>
                <input type="date" name="fecha" id="fecha" min="<?php echo date("Y-m-d", strtotime("+1 day"))?>">
            </div>
            <div class="campo">
                <label for="hora">Hora: </label>
                <input type="time" name="hora" id="hora">
            </div>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la Informacion sea Correcta.</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php

$script = '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/build/js/app.js"></script>
';