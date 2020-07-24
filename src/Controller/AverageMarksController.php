<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Services\calculateClassroomAverage;
use App\Services\CalculateClassroomAverage as ServicesCalculateClassroomAverage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AverageMarksController
{
    
    
    public function __invoke(Mark $data)
    {
        
        dd($data);
    }
}