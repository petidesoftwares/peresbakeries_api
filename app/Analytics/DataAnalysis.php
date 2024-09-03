<?php
namespace App\Analytics;

class DataAnalysis{

    public function calculatePieDataSector($val, $data)
    {
        return ($val/array_sum($data))*360;

    }

}