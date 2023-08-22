<?php

function debuguear($variable) : void {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function sanitizar($html) : string {
    $sanitizado = htmlspecialchars($html);
    return $sanitizado;
}

function alertaError($mensaje){
    ?><p class="alerta error"><?php echo $mensaje ?></p><?php
}

function alertaExito($mensaje){
    ?><p class="alerta exito"><?php echo $mensaje ?></p><?php
}

function esUltimo(string $actual, string $proximo) : bool {
    if($actual !== $proximo){
        return true;
    }
    return false;
}

function isAuth() : void {
    if(!isset($_SESSION["login"])){
        header("Location: /");
    }
}

function isAdmin() : void {
    if(!isset($_SESSION["login"]) || !isset($_SESSION["admin"])){
        header("Location: /");
    }
}

function redireccionar404($existe){
    if(!$existe){
        header("Location: /404");
    }
}