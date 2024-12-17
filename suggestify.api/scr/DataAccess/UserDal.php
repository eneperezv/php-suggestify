<?php

/*
 * @(#)UserDal.php 1.0 16/12/2024
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

class UserDal{

    public static function findById($userId) {
        $db = Connection::connect();
        
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result === false ? [] : $result;
    }
    
    public static function findByEmail($email) {
        $db = Connection::connect();
        
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result === false ? [] : $result;
    }

    public static function findAll() {
        $db = Connection::connect();
        
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result === false ? [] : $result;
    }

    public static function create($data) {
        $db = Connection::connect();
        // deberia ser solo con email y password
        try {
            $db->beginTransaction();
            $stmt = $db->prepare("INSERT INTO users (name, email, phone, password, role, timezone) 
                                  VALUES (:name, :email, :phone, :password, :role, :timezone)");
            $stmt->bindParam(":name", $data['name'], \PDO::PARAM_STR);
            $stmt->bindParam(":email", $data['email'], \PDO::PARAM_STR);
            $stmt->bindParam(":phone", $data['phone'], \PDO::PARAM_STR);
            $stmt->bindParam(":password", $data['password'], \PDO::PARAM_STR);
            $stmt->bindParam(":role", $data['role'], \PDO::PARAM_STR);
            $stmt->bindParam(":timezone", $data['timezone'], \PDO::PARAM_STR);
            $stmt->execute();
            $userId = $db->lastInsertId();
            $db->commit();

            return self::findById($userId);
        } catch (\PDOException $e) {
            $db->rollBack();
            throw new \Exception("Error al crear el usuario: " . $e->getMessage());
        }
    }

}

?>