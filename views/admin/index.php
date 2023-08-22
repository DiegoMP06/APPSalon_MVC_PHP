<h1 class="nombre-pagina">Panel de Administracion</h1>

<?php include __DIR__ . "/../templates/barra.php" ?>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha: </label>
            <input type="date" name="fecha" id="fecha" value="<?php echo $fecha?>">
        </div>
        <input type="button" value="Buscar" class="boton" id="buscar">
    </form>
</div>

<?php 
    if(count($citas) === 0){
        alertaError("No Hay Citas en Esta Fecha");
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita):
            if ($idCita !== $cita->id):
                $total = 0;
                ?>
                <li>
                    <p>ID: <span>
                            <?php echo $cita->id; ?>
                        </span></p>
                    <p>Hora: <span>
                            <?php echo $cita->hora; ?>
                        </span></p>
                    <p>Cliente: <span>
                            <?php echo $cita->cliente; ?>
                        </span></p>
                    <p>Email: <span>
                            <?php echo $cita->email; ?>
                        </span></p>
                    <p>Telefono: <span>
                            <?php echo $cita->telefono; ?>
                        </span></p>
                    <h3>Servicios</h3>
                    <?php
                    $idCita = $cita->id;
            endif;
            ?>
                <p class="servicio">
                    <?php echo $cita->servicio . ": $" . $cita->precio; ?>
                </p>
                <?php 
                $actual = $cita->id;
                $proximo = $citas[$key+1]->id ?? 0;

                $total += $cita->precio;

                if(esUltimo($actual, $proximo)){
                    ?><p>Total: <span>$<?php echo $total; ?></span></p>
                    
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" value="Eliminar" class="boton-eliminar">
                    </form>
                    <?php  
                }

                if ($idCita != $cita->id): ?>
                </li>
                <?php
                endif;
        endforeach;
        ?>
    </ul>
</div>


<?php 

$script = '<script src="build/js/buscador.js"></script>';