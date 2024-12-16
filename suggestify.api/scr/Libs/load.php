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
require_once "src/Libs/firebase-php-jwt/JWTExceptionWithPayloadInterface.php";
require_once "src/Libs/firebase-php-jwt/BeforeValidException.php";
require_once "src/Libs/firebase-php-jwt/CachedKeySet.php";
require_once "src/Libs/firebase-php-jwt/ExpiredException.php";
require_once "src/Libs/firebase-php-jwt/JWK.php";
require_once "src/Libs/firebase-php-jwt/JWT.php";
require_once "src/Libs/firebase-php-jwt/Key.php";
require_once "src/Libs/firebase-php-jwt/SignatureInvalidException.php";

// APP
// CONTROLLERS
require_once "src/Controllers/AuthController.php";
// require_once "src/Controllers/AuthorController.php";
// require_once "src/Controllers/PostController.php";
// require_once "src/Controllers/RoutesController.php";
// DATA ACCESS
// require_once "src/DataAccess/AuthorDal.php";
// require_once "src/DataAccess/PostDal.php";
// require_once "src/DataAccess/UserDal.php";
// MODELS
// require_once "src/Models/Author.php";
require_once "src/Models/Connection.php";
// require_once "src/Models/Post.php";
// require_once "src/Models/User.php";
// UTILS
require_once "src/Utils/EnvLoader.php";
require_once "src/Utils/Logger.php";
require_once "src/Utils/Response.php";
require_once "src/Utils/Utils.php";
require_once "src/Utils/Validator.php";

?>