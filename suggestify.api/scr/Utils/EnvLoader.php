<?php

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
