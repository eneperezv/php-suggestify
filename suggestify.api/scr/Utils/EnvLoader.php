<?php

/*
 * @(#)EnvLoader.php 1.0 15/12/2024
 * 
 * El código implementado en este formulario esta protegido
 * bajo las leyes internacionales del Derecho de Autor, sin embargo
 * se entrega bajo las condiciones descritas en The MIT License (MIT)
 * en https://opensource.org/license/mit
 */

/**
 * @author eliezer.navarro
 * @version 1.0
 * @since 1.0
 */

class EnvLoader{

    public static function load(string $path) {
        if (!file_exists($path)) {
            throw new \Exception("El archivo .env no existe en la ruta");
        }

        // Leer el archivo línea por línea
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Dividir en clave y valor
            $keyValue = explode('=', $line, 2);

            if (count($keyValue) === 2) {
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);

                // Almacenar en el entorno
                putenv("$key=$value"); // También puedes usar $_ENV[$key] = $value
            }
        }
    }

    public static function get(string $key, $default = null) {
        $value = getenv($key); // También puedes usar $_ENV[$key]
        return $value !== false ? $value : $default;
    }
    
}
