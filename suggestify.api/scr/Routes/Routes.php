<?php

/*
 * @(#)Routes.php 1.0 15/12/2024
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

$arrayRutas = explode("/",$_SERVER['REQUEST_URI']);

if(count(array_filter($arrayRutas)) == 2){
    // ---- NO EXISTE PUNTO DE ACCESO INICIAL
    $json = array("detalle"=>"No existe el recurso");
    Response::error('No existe el recurso',$json,404);
}else{
    // ---- ENCUENTRA PUNTO DE ACCESO
    if(count(array_filter($arrayRutas)) == 3){
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // ENDPOINT: /auth
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if(array_filter($arrayRutas)[3] == "auth"){
            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST" ){
                $body = json_decode(file_get_contents('php://input'), true);

                if (isset($body['email']) && isset($body['password'])) {
                    $datos = array(
                        'email' => $body['email'],
                        'password' => $body['password']
                    );
                    AuthController::login($body['email'], $body['password']);
                } else {
                    $err = array('error' => 'Faltan datos necesarios.');
                    Response::error('Bad Request', $err, 400);
                }
                
            }
        }
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // ENDPOINT: /register
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "register") {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                // Captura los datos enviados en el cuerpo de la solicitud
                $data = json_decode(file_get_contents("php://input"), true);

                /*if (isset($data['email']) && 
                        isset($data['password']) && 
                        isset($data['role']) && 
                        isset($data['name']) && 
                        isset($data['phone']) && 
                        isset($data['timezone'])*/
                if (isset($data['email']) && 
                        isset($data['password']) /*&& 
                        isset($data['role']) && 
                        isset($data['name']) && 
                        isset($data['phone']) && 
                        isset($data['timezone'])*/
                    ) {
                    AuthController::register($data);
                } else {
                    $err = array('error' => 'Faltan datos necesarios.');
                    Response::error('Bad Request', $err, 400);
                }
            } else {
                $err = array('error' => 'Método no permitido.');
                Response::error("Method Not Allowed", $err, 405);
            }
        }
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // ENDPOINT: /validate-token
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "validate-token") {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                
                $headers = function_exists('getallheaders') ? getallheaders() : [];
                $errors = Utils::headerTokenValidate($headers);
                if (!empty($errors)) {
                    Response::error('Unauthorized', $errors, 401);
                    exit;
                }
                Response::success("Token válido", [], 200, "response");

            } else {
                $err = array('error' => 'Método no permitido.');
                Response::error("Method Not Allowed", $err, 405);
            }
        }
    }elseif(count(array_filter($arrayRutas)) >= 4){
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // MODULE: /user
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "user"){
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /user/update
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "update"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $data = json_decode(file_get_contents("php://input"), true);
                    if (isset($data['email']) && 
                        isset($data['password']) && 
                        isset($data['role']) && 
                        isset($data['name']) && 
                        isset($data['phone']) && 
                        isset($data['timezone'])
                        ) {
                        UserController::update($data);
                    } else {
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                } else {
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
        }
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // MODULE: /post
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "post"){
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/create
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "create"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $data = json_decode(file_get_contents("php://input"), true);
                    if (isset($data['title']) && 
                        isset($data['content']) && 
                        isset($data['author_id'])) {
                        PostController::create($data);
                    } else {
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                } else {
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/find-by-id/{post_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-id"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }

                        $post = PostController::findById($arrayRutas[5]);
                        if(empty($post)){
                            $err = array('error' => 'No se encuentra el post solicitado.');
                            Response::error('No Content', $err, 204);
                        }else{
                            Response::success('OK', $post, 200, 'post');
                        }
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/find-by-author/{author_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-author"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }

                        $post = PostController::findByAuthorId($arrayRutas[5]);
                        if(empty($post)){
                            $err = array('error' => 'No se encuentran post asociados al autor.');
                            Response::error('No Content', $err, 200);
                        }else{
                            Response::success('OK', $post, 200, 'post');
                        }
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/find-all-posts
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-all-posts"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenRootValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $post = PostController::findAllPosts();
                    if(empty($post)){
                        $err = array('error' => 'No se encuentran posts.');
                        Response::error('No Content', $post, 200);
                    }else{
                        Response::success('OK', $post, 200, 'post');
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/set-vote
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "set-vote"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $data = json_decode(file_get_contents("php://input"), true);
                    if (isset($data['post_id']) && 
                        isset($data['option']) && 
                        isset($data['user_id'])) {
                        PostController::setVote($data);
                    } else {
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                } else {
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /post/set-comment
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "set-comment"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $data = json_decode(file_get_contents("php://input"), true);
                    if (isset($data['post_id']) && 
                        isset($data['content']) && 
                        isset($data['user_id'])) {
                        PostController::setComment($data);
                    } else {
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                } else {
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
        }
        if (array_filter($arrayRutas)[3] == "author"){
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /author/find-by-id/{author_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-id"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }

                        $post = AuthorController::findById($arrayRutas[5]);
                        if(empty($post)){
                            $err = array('error' => 'No se encuentra el autor solicitado.');
                            Response::error('No Content', $err, 204);
                        }else{
                            Response::success('OK', $post, 200, 'author');
                        }
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
        }
        /*
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // MODULE: /operators
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "operators"){
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /operators/find-by-id/{service_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-id"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }

                        $operator = Operator::findById($arrayRutas[5]);
                        if(empty($operator)){
                            $err = array('error' => 'No se encuentra la disponibilidad para el operadot.');
                            Response::error('No Content', $err, 204);
                        }else{
                            Response::success('OK', $operator, 200, 'op-schedule');
                        }
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /operators/find-by-business/{business_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-business"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }

                        $operators = Operator::findByBusinessId($arrayRutas[5]);
                        if(empty($operators)){
                            $err = array('error' => 'No se encuentran operadores asociados a la empresa.');
                            Response::error('No Content', $err, 200);
                        }else{
                            Response::success('OK', $operators, 200, 'operator');
                        }
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /operators/find-all
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-all"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenRootValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $operators = Operator::findAll();
                    if(empty($operators)){
                        $err = array('error' => 'No se encuentran operadores.');
                        Response::error('No Content', $err, 200);
                    }else{
                        Response::success('OK', $operators, 200, 'operator');
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /operators/add-schedule
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "add-schedule"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                    $headers = function_exists('getallheaders') ? getallheaders() : [];
                    $errors = Utils::headerTokenValidate($headers);
                    if (!empty($errors)) {
                        return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                        exit();
                    }

                    $data = json_decode(file_get_contents("php://input"), true);
                    if (isset($data['operator_id']) && 
                        isset($data['start_time']) && 
                        isset($data['end_time']) && 
                        isset($data['date'])) {
                        OperatorController::create($data);
                    } else {
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                } else {
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }
        }
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // MODULE: /appointments
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        if (array_filter($arrayRutas)[3] == "appointments"){
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            // ENDPOINT: /appointments/find-by-business/{business_id}
            // ------------------------------------------------------------------------------------------------
            // ------------------------------------------------------------------------------------------------
            if (array_filter($arrayRutas)[4] == "find-by-business"){
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($arrayRutas[5]) && Validator::validateInteger($arrayRutas[5])){

                        $headers = function_exists('getallheaders') ? getallheaders() : [];
                        $errors = Utils::headerTokenValidate($headers);
                        if (!empty($errors)) {
                            return Response::error('Ha ocurrido un error en la solicitud.', $errors, 422);
                            exit();
                        }
                        
                        //$operators = Operator::findByBusinessId($arrayRutas[5]);
                        //if(empty($operators)){
                        //    $err = array('error' => 'No se encuentran operadores asociados a la empresa.');
                        //    Response::error('No Content', $err, 200);
                        //}else{
                        //    Response::success('OK', $operators, 200, 'operator');
                        //}
                        
                    }else{
                        $err = array('error' => 'Faltan datos necesarios.');
                        Response::error('Bad Request', $err, 400);
                    }
                }else{
                    $err = array('error' => 'Método no permitido.');
                    Response::error("Method Not Allowed", $err, 405);
                }
            }

        }
        */
    }
}
?>