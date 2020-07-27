<?php

namespace App\Tests\Entity;

use App\Entity\Student;
use PHPUnit\Framework\TestCase;
use \DateTime;

class StudentTest extends TestCase
{
    public function testFirstName()
    {
        $student = new Student();
        $firstName = "Julien";
        
        $student->setFirstName($firstName);
        $this->assertEquals("Julien", $student->getFirstName());
    }

    public function testLastName()
    {
        $student = new Student();
        $lastName = "Durand";
        
        $student->setLastName($lastName);
        $this->assertEquals("Durand", $student->getLastName());
    }

    public function testBirthday()
    {
        $student = new Student();
        $birthday = new DateTime("2011-06-17");
        
        $student->setBirthday($birthday);
        $this->assertEquals(new DateTime("2011-06-17"), $student->getBirthday());
    }
}