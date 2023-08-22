<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el Siguiente Formulario para Crear una Cuenta.</p>

<form class="formulario" action="/crear-cuenta" method="post">
    <?php echo (isset($alertas['error']["usuario"])) ? alertaError($alertas['error']["usuario"]) : '' ?>
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre"
            value="<?php echo sanitizar($usuario->nombre) ?>">
    </div>
    <?php echo (isset($alertas['error']["nombre"])) ? alertaError($alertas['error']["nombre"]) : '' ?>

    <div class="campo">
        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido"
            value="<?php echo sanitizar($usuario->apellido) ?>">
    </div>
    <?php echo (isset($alertas['error']["apellido"])) ? alertaError($alertas['error']["apellido"]) : '' ?>

    <div class="campo">
        <label for="telefono">Telefono: </label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu Numero de Telefono"
            value="<?php echo sanitizar($usuario->telefono) ?>">
    </div>
    <?php echo (isset($alertas['error']["telefono"])) ? alertaError($alertas['error']["telefono"]) : '' ?>

    <div class="campo">
        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email" placeholder="Tu E-mail"
            value="<?php echo sanitizar($usuario->email) ?>">
    </div>
    <?php echo (isset($alertas['error']["email"])) ? alertaError($alertas['error']["email"]) : '' ?>

    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>
    <?php echo (isset($alertas['error']["password"])) ? alertaError($alertas['error']["password"]) : '' ?>

    <input class="boton" type="submit" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes una Cuenta? Iniciar Sesion.</a>
    <a href="/olvide">¿Olvidaste tu Contraseña?.</a>
</div>