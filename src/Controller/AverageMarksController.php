<?php

namespace App\Controller;

class AverageMarksController
{
    public function __invoke($data)
    {
        $numberMarks = count($data);
        $sumMarks = array_reduce($data, function ($total, $mark) {
            return $total + $mark->getValue();
        }, 0);
        
        return $sumMarks/$numberMarks;
    }
}
