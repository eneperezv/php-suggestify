<?php

class MachineLearningService{

    private $dataAnalysis;

    public function __construct() {
        $this->dataAnalysis = new DataAnalysisService();
    }

    // Simulación de entrenamiento (placeholder)
    public function trainModel($trainingData) {
        // Guardar o entrenar un modelo. Simulación.
        return "Modelo entrenado con " . count($trainingData) . " registros.";
    }

    // Generar una predicción (simulación)
    public function predict($data) {
        // Preprocesar datos
        $features = $this->dataAnalysis->extractFeatures($data);

        // Simular una predicción usando una regla simple
        $score = 0;
        foreach ($features as $feature => $value) {
            $score += $value;
        }
        $prediction = $score > 5 ? "Alta recomendación" : "Baja recomendación";

        return [
            'prediction' => $prediction,
            'score' => round($score, 2),
            'features' => $features
        ];
    }

}

?>