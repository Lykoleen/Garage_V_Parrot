<?php

namespace App\Utils;

class Utils
{
    
    public function tranchesHoraires()
    {
        $options = "";
        
        for ($heures = 6; $heures <= 20; $heures++) {
            for ($minutes = 0; $minutes < 60; $minutes += 30) {
                $heure = str_pad($heures, 2, '0', STR_PAD_LEFT);
                $minute = ($minutes === 0) ? '00' : $minutes;
                $heureFormat = $heure . ':' . $minute;
                $options .= '<option value="' . $heureFormat . '">' . $heureFormat . '</option>';
            }
        }

        return $options;
    }

    public function genererOptionHeure($heureFormat)
    {
        if ($heureFormat == '00:00') {
            return "<option value=''>Aucun</option>";
        } else {
            return "<option value='$heureFormat'>$heureFormat</option>";
        }
    }
}