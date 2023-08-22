<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu Contraseña nueva a Continuacion</p>

<?php echo (isset($alertas["error"]["token"])) ? alertaError($alertas["error"]["token"]) : ''; ?>

<?php if($error) return; ?>
<form method="post" class="formulario">
    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña Nueva">
    </div>
    <?php echo (isset($alertas['error']["password"])) ? alertaError($alertas['error']["password"]) : '' ?>

    <input type="submit" value="Actualizar Contraseña" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes una Cuenta? Iniciar Sesion.</a>
    <a href="/crear-cuenta">¿Aun no Tienes una Cuenta? Crear una.</a>
</div>