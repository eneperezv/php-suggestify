<?php

/*
 * @(#)Response.php 1.0 15/12/2024
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

class Response{

    public static function getResponse(string $status, int $statusCode, string $message, array $responseData, string $entityName = null){
        
        if ($entityName) {
            $response_final = [
                'entity' => $entityName,  // Nombre de la entidad
                'content' => $responseData // Datos reales de la entidad
            ];
        } else {
            // Si no hay nombre de entidad, los datos de respuesta se colocan directamente
            $response_final = $responseData;
        }

        $response = [
            'status' => $status,
            'status_code' => $statusCode,
            'timestamp' => date('Y-m-d H:i:s'),
            'response_data' => $response_final,
            'message' => $message,
        ];

        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($response);
        return;
    }

    public static function success(string $message, array $responseData, int $statusCode, string $entityName){
        self::getResponse('OK',$statusCode,$message,$responseData,$entityName);
        exit();
    }

    public static function error(string $message, array $responseData, int $statusCode){
        self::getResponse('ERROR',$statusCode,$message,$responseData);
        exit();
    }

}

?>