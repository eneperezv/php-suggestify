<?php

class Recomendation{

    public static function saveRecommendation($userId, $content, $algorithm, $score) {
        $result = RecomendationDal::saveRecommendation($userId, $content, $algorithm, $score);
        return $result;
    }

    public static function getRecommendationsByUser($userId) {
        $result = RecomendationDal::getRecommendationsByUser($userId);
        return $result;
    }

}

?>