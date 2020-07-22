<?php

namespace App\DataFixtures;

use App\Entity\Mark;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        for ($s = 0; $s < 20; $s++) {
            $student = new Student;
            $student->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setBirthday($faker->dateTimeBetween($startDate = '-10 years', $endDate = '-9 years', $timezone = null));
            
            $manager->persist($student);

            for ($m = 0; $m < 5; $m++) {
                $mark = new Mark;
                $mark->setValue($faker->numberBetween($min = 0, $max = 20))
                     ->setSubject($faker->word())
                     ->setStudent($student);

                $manager->persist($mark);
            }
        }

        $manager->flush();
    }
}
