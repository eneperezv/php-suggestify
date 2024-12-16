<?php

class Logger{
    private static $logDir;          // Directorio donde se almacenan los logs
    private static $currentLogFile;  // Archivo de log actual

    public static function initialize(string $logDir = __DIR__ . '/../logs') {
        self::$logDir = rtrim($logDir, '/');
        self::initializeLogFile();
    }

    private static function initializeLogFile() {
        // Asegúrate de que el directorio exista
        if (!file_exists(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }

        // Archivo de log actual
        self::$currentLogFile = self::$logDir . '/app.log';

        // Si existe el archivo actual, renómbralo con la fecha de ayer
        if (file_exists(self::$currentLogFile)) {
            $yesterday = date('Y-m-d', strtotime('yesterday'));
            $oldLogFile = self::$logDir . "/app_$yesterday.log";

            if (!file_exists($oldLogFile)) { // Evitar sobrescribir
                rename(self::$currentLogFile, $oldLogFile);
            }
        }

        // Crear el nuevo archivo de log para hoy
        //file_put_contents(self::$currentLogFile, "=== Log iniciado el " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
        if (!file_exists(self::$currentLogFile)) {
            // Escribimos la línea de inicio solo una vez al crear el archivo del día
            file_put_contents(self::$currentLogFile, "=== Log iniciado el " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
        }
    }

    public static function log(string $level, string $message) {
        // Formato del mensaje: [nivel][fecha-hora] Mensaje
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$level][$timestamp] $message\n";

        // Escribir en el archivo de log
        file_put_contents(self::$currentLogFile, $logMessage, FILE_APPEND);
    }

    public static function info(string $message) {
        self::log('INFO', $message);
    }

    public static function warning(string $message) {
        self::log('WARNING', $message);
    }

    public static function error(string $message) {
        self::log('ERROR', $message);
    }
}
