<?php

/*
 * @(#)Validator.php 1.0 15/12/2024
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

class Validator {

    public static function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword(string $password): bool {
        $pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";
        return preg_match($pattern, $password) === 1;
    }

    public static function validateText(string $text): bool {
        $pattern = '/^[\p{L}\p{N}\s.,\'"?!¡¿()@\-:;]+$/u';
        return preg_match($pattern, $text) === 1;
    }
    
    public static function validateInteger($value): bool {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    public static function validateDecimal($value): bool {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function validateTime24H(string $text): bool {
        $format = 'H:i:s';
        $time = DateTime::createFromFormat($format, $text);
        return $time && $time->format($format) === $text;
    }

    public static function validateDate(string $text): bool {
        $format = 'Y-m-d';
        $date = DateTime::createFromFormat($format, $text);
        return $date && $date->format($format) === $text;
    }

    public static function validateTextOptions(string $text): bool{
        $pattern = '/^(UP|DOWN)$/';
        return preg_match($pattern, $text) === 1;
    }

    // CONSULTA POR ID GENERAL
    public static function validateConsultaPorId($dataId): array {
        $errors = [];
        if (!self::validateInteger($dataId)) {
            $errors[] = "La consulta debe incluir un número entero.";
        }
        return $errors;
    }

    // VALIDACION DE DATOS PARA AUTENTICACION
    public static function validateCredentials(string $email, string $password): array {
        $errors = [];
        if (!self::validateEmail($email)) {
            $errors[] = "El correo electrónico no es válido.";
        }
        if (!self::validatePassword($password)) {
            $errors[] = "La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, un número y un carácter especial.";
        }
        return $errors;
    }

    // VALIDACION DE DATOS PARA POST
    public static function validateDataPost($data): array {
        $errors = [];
        if (!self::validateText($data['title'])) {
            $errors[] = "El campo 'title' contiene caracteres inválidos.";
        }
        if (!self::validateText($data['content'])) {
            $errors[] = "El campo 'content' contiene caracteres inválidos.";
        }
        if (!self::validateInteger($data['author_id'])) {
            $errors[] = "El campo 'author_id' debe ser un número entero.";
        }
        return $errors;
    }

    // VALIDACION DE DATOS PARA VOTES
    public static function validateDataVotes($data): array {
        $errors = [];
        if (!self::validateInteger($data['post_id'])) {
            $errors[] = "El campo 'post_id' debe ser un número entero.";
        }
        if (!self::validateTextOptions($data['option'])) {
            $errors[] = "El campo 'option' debe ser UP o DOWN.";
        }
        if (!self::validateInteger($data['user_id'])) {
            $errors[] = "El campo 'user_id' debe ser un número entero.";
        }
        return $errors;
    }

    // VALIDACION DE DATOS PARA COMMENTS
    public static function validateDataComments($data): array {
        $errors = [];
        if (!self::validateInteger($data['post_id'])) {
            $errors[] = "El campo 'post_id' debe ser un número entero.";
        }
        if (!self::validateText($data['content'])) {
            $errors[] = "El campo 'content' debe ser texto.";
        }
        if (!self::validateInteger($data['user_id'])) {
            $errors[] = "El campo 'user_id' debe ser un número entero.";
        }
        return $errors;
    }

}


?>