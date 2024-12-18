<?php

class RecomendationDal{

    public static function saveRecommendation($userId, $content, $algorithm, $score) {
        $db = Connection::connect();

        try {
            $stmt = $db->prepare("INSERT INTO recommendations (user_id, content, algorithm, score, created_at) 
                                        VALUES (:user_id, :content, :algorithm, :score, NOW())");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':algorithm', $algorithm, PDO::PARAM_STR);
            $stmt->bindParam(':score', $score, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al guardar la recomendación: " . $e->getMessage());
        }
    }

    public static function getRecommendationsByUser($userId) {
        $db = Connection::connect();

        try {
            $stmt = $db->prepare("SELECT * FROM recommendations WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener recomendaciones: " . $e->getMessage());
        }
    }

}

?>