<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWTExceptionWithPayloadInterface;

class Utils{

    public static function generateToken($userId,$userEmail,$userTimezone) {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode([
            'sub' => $userId,
            'email' => $userEmail,
            'timezone' => $userTimezone,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ]);

        $secret = EnvLoader::get('APP_SECRET');

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function validateToken($token) {
        if (!$token) {
            return null;
        }
    
        try {
            $secret = EnvLoader::get('APP_SECRET');
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function headerTokenValidate($headers): array {
        $errors = [];
        if (empty($headers)) {
            $errors[] = ['error' => 'No se pudieron obtener los encabezados.'];
        }else{
            if (isset($headers['Authorization'])) {
                $token = str_replace('Bearer ', '', $headers['Authorization']);
                $decoded = Utils::validateToken($token);
                if (!$decoded) {
                    $errors[] = ['error' => 'Token inválido o expirado.'];
                }
            } else {
                $errors[] = ['error' => 'Token no encontrado.'];
            }
        }
        return $errors;
    }

    public static function headerTokenRootValidate($headers): array {
        $errors = [];
        if (empty($headers)) {
            $errors[] = ['error' => 'No se pudieron obtener los encabezados.'];
        }else{
            if (isset($headers['Authorization'])) {
                $token = str_replace('Bearer ', '', $headers['Authorization']);
                $decoded = Utils::validateToken($token);
                if (!$decoded) {
                    $errors[] = ['error' => 'Token inválido o expirado.'];
                }else{
                    $user = User::findById($decoded['sub']);
                    if($user['role'] != 'admin'){
                        $errors[] = ['error' => 'Este Rol de usuario no puede consultar todos los servicios.'];
                    }
                }
            } else {
                $errors[] = ['error' => 'Token no encontrado.'];
            }
        }
        return $errors;
    }

}
?>