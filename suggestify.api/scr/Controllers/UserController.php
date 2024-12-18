<?php

class UserController{

    public static function update($data) {

        $userData = User::findByEmail($data['email']);
        if(empty($userData)) {
            return Response::error('No hay usuarios registrados con el email proporcionado.', $data, 400);
        }
        
        $errors = Validator::validateDataUserUpdate($data);
        if (!empty($errors)) {
            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
        }

        try {
            $userDetails = User::update($data);

            if ($userDetails) {
                return Response::success('Actualizacion de usuario', $userDetails, 200, 'user');
            } else {
                $err = array('error' => 'Error al consultar el usuario.');
                return Response::error('Ha ocurrido un error en la solicitud.', $err, 422);
            }
        } catch (\Exception $e) {
            $err = array('error' => 'Error en el servidor: ' . $e->getMessage());
            return Response::error('Error en el servidor', $err, 500);
        }
        
    }

}

?>