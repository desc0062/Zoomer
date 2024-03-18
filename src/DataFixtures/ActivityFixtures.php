<?php

namespace App\DataFixtures;

use App\Factory\ActivityFactory;
use App\Factory\AnimalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ActivityFactory::createMany(20, function () {
            $animal = AnimalFactory::createOne();

            return [
                'animal' => $animal,
            ];
        });
    }
}
