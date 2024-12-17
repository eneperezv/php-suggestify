<?php

/*
 * @(#)AuthController.php 1.0 15/12/2024
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

class AuthController{

    public static function login($email, $password) {
        try {
            $db = Connection::connect();

            $stmt = $db->prepare("SELECT id, password, timezone FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$user || !password_verify($password, $user['password'])) {
                $err = array("detalle"=>"Las credenciales proporcionadas no son válidas. Verifique sus datos de acceso.");
                return Response::error('Credenciales inválidas', $err, 401);
            }

            if (in_array($user['timezone'], timezone_identifiers_list())) {
                date_default_timezone_set($user['timezone']);
            } else {
                date_default_timezone_set('UTC');
            }

            $token = Utils::generateToken($user['id'],$email,$user['timezone']);

            $data = [
                'id' => $user['id'],
                'token' => $token
            ];
            
            Logger::info("Login correcto para el usuario: $email");
            return Response::success('Inicio de sesión exitoso', $data, 200, 'token');
        } catch (\Exception $e) {
            Logger::warning("Login fallido para el usuario: $email");
            $err = array("detalle"=>$e);
            return Response::error('Error interno del servidor', $err, 500);
        }
    }

    public static function register($data) {
        $email = trim($data['email']);
        $password = $data['password'];

        $errors = Validator::validateCredentials($email, $password);
        if (!empty($errors)) {
            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            if (User::findByEmail($email)) {
                $err = array('error' => 'El usuario ya está registrado.');
                return Response::error('Ha ocurrido un error en la solicitud.', $err, 422);
            }
            if (User::create($data,$hashedPassword)) { //aqui ocurre el error
                $userDetails = User::findByEmail($email);
                return Response::success('Usuario registrado con éxito.', $userDetails, 201, 'user');
            } else {
                $err = array('error' => 'Error al registrar al usuario.');
                return Response::error('Ha ocurrido un error en la solicitud.', $err, 422);
            }
        } catch (\Exception $e) {
            $err = array('error' => 'Error en el servidor: ' . $e->getMessage());
            return Response::error('Error en el servidor', $err, 500);
        }
    }

}

?>