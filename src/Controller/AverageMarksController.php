<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Services\calculateClassroomAverage;
use App\Services\CalculateClassroomAverage as ServicesCalculateClassroomAverage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
