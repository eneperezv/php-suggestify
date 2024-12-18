<?php

class DataAnalysisService{

    // Normalizar datos (ejemplo: escala 0-1)
    public function normalizeData($data) {
        $normalized = [];
        foreach ($data as $key => $value) {
            $min = min($value);
            $max = max($value);
            $normalized[$key] = array_map(function($item) use ($min, $max) {
                return ($max - $min) == 0 ? 0 : ($item - $min) / ($max - $min);
            }, $value);
        }
        return $normalized;
    }

    // Extraer características relevantes (simulación)
    public function extractFeatures($data) {
        // En este ejemplo, calculamos la media de cada conjunto de datos
        $features = [];
        foreach ($data as $key => $values) {
            $features[$key . '_mean'] = array_sum($values) / count($values);
        }
        return $features;
    }

}

?>