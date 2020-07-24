<?php

namespace App\Controller;

use App\Entity\Student;

class AverageStudentController
{
    public function __invoke(Student $data)
    {
        $numberMarks = count($data->getMarks());
        $sumMarks = array_reduce($data->getMarks()->toArray(), function ($total, $mark) {
            return $total + $mark->getValue();
        }, 0);
        $average = $sumMarks/$numberMarks;
        
        return $average;
    }
}
