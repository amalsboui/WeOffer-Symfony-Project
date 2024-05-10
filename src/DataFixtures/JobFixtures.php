<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager ,): void
    {
      $job= new Job();
      $faker = Factory::create();
        //$jobs = ['Software Engineer', 'Marketing Manager', 'Graphic Designer', 'Project Manager'];

        for($i=1; $i<21; $i++){
            $job->setRecruiter($i % 5);
            $job->setPosition($faker->jobTitle());
            $job->setDescription($faker->text($maxNbChars = 200));
            $job->setEntreprise($faker->company());
            $job->setCreatedAt($faker->dateTimeBetween($startDate = '-5 months', $endDate = 'now'));
            $job->setLocation($faker->city());
            $job->setEmploymentType($faker->word());
            $job->setCategory($faker->word());


        }

         $manager->persist($job);

        $manager->flush();
    }
}
