<?php

date_default_timezone_set('America/Bogota');

include "scr/Libs/load.php";

try {
    // LOAD DE ARCHIVO .env
    EnvLoader::load(__DIR__ . '/.env');

    // INIT DEL LOGGER
    Logger::initialize(__DIR__ . '/logs');

    // INIT DE LA APLICACION
    $rutas = new RoutesController();
    $rutas->inicio();

} catch (Exception $e) {
    die($e->getMessage());
}
?>