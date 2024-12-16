<?php

/*
 * @(#)Connection.php 1.0 15/12/2024
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

class Connection{

    public static function connect(){
        $link = new PDO("mysql:host=localhost;dbname=suggestify","root","");
        $link->exec("set names utf8");
        return $link;
    }

}

?>