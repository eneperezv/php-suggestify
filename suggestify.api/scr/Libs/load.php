<?php

/*
 * @(#)load.php 1.0 15/12/2024
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

// LIBRERIAS
require_once "scr/Libs/firebase-php-jwt/JWTExceptionWithPayloadInterface.php";
require_once "scr/Libs/firebase-php-jwt/BeforeValidException.php";
require_once "scr/Libs/firebase-php-jwt/CachedKeySet.php";
require_once "scr/Libs/firebase-php-jwt/ExpiredException.php";
require_once "scr/Libs/firebase-php-jwt/JWK.php";
require_once "scr/Libs/firebase-php-jwt/JWT.php";
require_once "scr/Libs/firebase-php-jwt/Key.php";
require_once "scr/Libs/firebase-php-jwt/SignatureInvalidException.php";

// APP
// UTILS
require_once "scr/Utils/EnvLoader.php";
require_once "scr/Utils/Logger.php";
require_once "scr/Utils/Response.php";
require_once "scr/Utils/Utils.php";
require_once "scr/Utils/Validator.php";
// CONTROLLERS
require_once "scr/Controllers/RoutesController.php";
require_once "scr/Controllers/AuthController.php";
require_once "scr/Controllers/UserController.php";
// require_once "scr/Controllers/PostController.php";
// DATA ACCESS
// require_once "scr/DataAccess/AuthorDal.php";
// require_once "scr/DataAccess/PostDal.php";
require_once "scr/DataAccess/UserDal.php";
// MODELS
// require_once "scr/Models/Author.php";
require_once "scr/Models/Connection.php";
// require_once "scr/Models/Post.php";
require_once "scr/Models/User.php";

?>