<?php

/*
 * @(#)PostDal.php 1.0 16/12/2024
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

class User{

    public static function findById($userId) {
        $result = UserDal::findById($userId);
        return $result === false ? [] : $result;
    }

    public static function findByEmail($email) {
        $result = UserDal::findByEmail($email);
        return $result === false ? [] : $result;
    }

    public static function findAll() {
        $result = UserDal::findAll();
        return $result === false ? [] : $result;
    }

    public static function create($data, $password) {
        $result = UserDal::create($data, $password);
        return $result === false ? [] : $result;
    }

    public static function update($data){
        $result = UserDal::update($data);
        return $result === false ? [] : $result;
    }

}

?>