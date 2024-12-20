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

    public static function create($data, $password) {
        $db = Connection::connect();
        
        try {
            $db->beginTransaction();
            $stmt = $db->prepare("INSERT INTO users (name, email, phone, password, role, timezone) 
                                  VALUES (:name, :email, :phone, :password, :role, :timezone)");
            $stmt->bindParam(":name", $data['name'], \PDO::PARAM_STR);
            $stmt->bindParam(":email", $data['email'], \PDO::PARAM_STR);
            $stmt->bindParam(":phone", $data['phone'], \PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, \PDO::PARAM_STR);
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

    public static function update($data){
        $db = Connection::connect();

        try {
            $fields = [];
            $params = [];
    
            if (!empty($data['name'])) {
                $fields[] = "name = :name";
                $params[':name'] = $data['name'];
            }
            if (!empty($data['phone'])) {
                $fields[] = "phone = :phone";
                $params[':phone'] = $data['phone'];
            }
            if (!empty($data['password'])) {
                $fields[] = "password = :password";
                $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            if (!empty($data['role'])) {
                $fields[] = "role = :role";
                $params[':role'] = $data['role'];
            }
            if (!empty($data['timezone'])) {
                $fields[] = "timezone = :timezone";
                $params[':timezone'] = $data['timezone'];
            }
    
            if (empty($fields)) {
                throw new Exception("No hay datos válidos para actualizar.");
            }
    
            $sql = "UPDATE users SET " . implode(", ", $fields) . ", updated_at = now() WHERE id = :id";
            $params[':id'] = $data['id'];
    
            $db->beginTransaction();
    
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
    
            $db->commit();
    
            return self::findById($data['id']);
    
        } catch (PDOException $e) {
            $db->rollBack();
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

}

?>