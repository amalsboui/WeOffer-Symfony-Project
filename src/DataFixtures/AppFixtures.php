<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;

use DateTimeImmutable;

use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $user_type = ['recruiter', 'jobseeker', 'admin'];
        $jobs = ['Software Engineer', 'Marketing Manager', 'Graphic Designer', 'Project Manager'];
        for ($i = 0; $i <3; $i++) {
            $user = new User();
            $user->setName($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setUserType($faker->randomElement($user_type));
            $user->setJob($faker->randomElement($jobs));
            $user->setCity($faker->city);
            $user->setImageUrl($faker->imageUrl($width = 640, $height = 480));

            $dateTimeImmutable = new DateTimeImmutable();
            $dateTimeImmutable = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-05-12 15:30:00');
            $user->setCreatedAt($dateTimeImmutable);

            if($user->getUserType() == 'recruiter'){
                $user->setPersonalInfo($faker->company);
            }

            else if($user->getUserType() == 'jobseeker'){
                $user->setPersonalInfo($faker->text([50]));
            }

            $manager->persist($user);
        }
        $manager->flush();

    }
}
