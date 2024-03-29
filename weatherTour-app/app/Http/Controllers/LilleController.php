<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LilleController extends Controller
{
    public function getCSVFromS3()
    {
        // Liste des fichiers CSV à récupérer
        $csvFiles = [
            'donnees_meteo_actuelles_Lille.csv'
        ];

        $csvData = [];

        // Utilisation de la façade Storage
        foreach ($csvFiles as $csvFile) {
            $contents = Storage::disk('s3')->get($csvFile);
            $lines = explode("\n", $contents);
            $data = [];

            foreach ($lines as $line) {
                $data[] = str_getcsv($line, ",");
            }

            $csvData[$csvFile] = $data;
        }

        // Récupérer les informations nécessaires (heure de l'enregistrement, lever et coucher du soleil, description, nom de la ville)
        $recordedTime = $csvData['donnees_meteo_actuelles_Lille.csv'][1][9]; // Exemple, ajustez en fonction de la structure réelle
        $sunrise = $csvData['donnees_meteo_actuelles_Lille.csv'][1][10]; // Exemple, ajustez en fonction de la structure réelle
        $sunset = $csvData['donnees_meteo_actuelles_Lille.csv'][1][11]; // Exemple, ajustez en fonction de la structure réelle
        $description = $csvData['donnees_meteo_actuelles_Lille.csv'][1][1]; // Exemple, ajustez en fonction de la structure réelle
        $cityName = "Lille"; // Exemple, ajustez en fonction de la structure réelle
        $temperature = $csvData['donnees_meteo_actuelles_Lille.csv'][1][2]; // Exemple, ajustez en fonction de la structure réelle
        $humidite = $csvData['donnees_meteo_actuelles_Lille.csv'][1][7]; // Exemple, ajustez en fonction de la structure réelle
        $vent = $csvData['donnees_meteo_actuelles_Lille.csv'][1][8]; // Exemple, ajustez en fonction de la structure réelle
        $pression = $csvData['donnees_meteo_actuelles_Lille.csv'][1][6]; // Exemple, ajustez en fonction de la structure réelle


        return view('lillePage', [
            'recordedTime' => $recordedTime,
            'sunrise' => $sunrise,
            'sunset' => $sunset,
            'description' => $description,
            'cityName' => $cityName,
            'temperature'=>$temperature,
            'humidite'=>$humidite,
            'vent'=>$vent,
            'pression'=>$pression,
        ]);
    }
}
