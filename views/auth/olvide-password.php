<h1 class="nombre-pagina">Olvide mi Contraseña</h1>
<p class="descripcion-pagina">Reestablece tu Contraseña Escribiendo tu E-mail a Continuacion.</p>

<form class="formulario" action="/olvide" method="post">

    <?php echo (isset($alertas["exito"]["usuario"])) ? alertaExito($alertas["exito"]["usuario"]) : '' ?>
    <?php echo (isset($alertas["error"]["usuario"])) ? alertaError($alertas["error"]["usuario"]) : '' ?>

    <div class="campo">
        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email" placeholder="Tu E-mail">
    </div>
    <?php echo (isset($alertas['error']['email'])) ? alertaError($alertas['error']['email']) : '' ?>

    <input class="boton" type="submit" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes una Cuenta? Iniciar Sesion.</a>
    <a href="/crear-cuenta">¿Aun no Tienes una Cuenta? Crear una.</a>
</div>