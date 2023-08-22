<h1 class="nombre-pagina">Confirmar Cuenta</h1>

<?php echo (!isset($alertas["exito"]["token"])) ? alertaError($alertas["error"]["token"]) : alertaExito($alertas["exito"]["token"]); ?>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
</div>