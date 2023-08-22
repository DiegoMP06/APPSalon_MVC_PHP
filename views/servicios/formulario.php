<div class="campo">
    <label for="nombre">Nombre: </label>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre Servicio" value="<?php echo $servicio->nombre ?>">
</div>
<?php echo (isset($alertas['error']['nombre'])) ? alertaError($alertas['error']['nombre']) : '' ?>

<div class="campo">
    <label for="precio">Precio: </label>
    <input step="0.01" type="number" name="precio" id="precio" min="1" placeholder="Precio Servicio" value="<?php echo $servicio->precio ?>">
</div>
<?php echo (isset($alertas['error']['precio'])) ? alertaError($alertas['error']['precio']) : '' ?>