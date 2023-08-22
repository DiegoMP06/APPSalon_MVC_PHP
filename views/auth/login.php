<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus Datos.</p>

<form class="formulario" action="/" method="post">
    <?php echo (isset($alertas['error']["usuario"])) ? alertaError($alertas['error']["usuario"]) : '' ?>

    <div class="campo">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu Email"
            value="<?php echo sanitizar($auth->email) ?>">
    </div>
    <?php echo (isset($alertas['error']['email'])) ? alertaError($alertas['error']['email']) : '' ?>

    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>
    <?php echo (isset($alertas['error']['password'])) ? alertaError($alertas['error']['password']) : '' ?>

    <input class="boton" type="submit" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no Tienes una Cuenta? Crear una.</a>
    <a href="/olvide">¿Olvidaste tu Contraseña?.</a>
</div>