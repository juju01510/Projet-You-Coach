<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\CategoryFactory;
use App\Factory\ClubFactory;
use App\Factory\SportFactory;
use App\Factory\TeamFactory;
use App\Factory\TrainingFactory;
use App\Factory\ManagerFactory;
use App\Factory\PlayerFactory;
use App\Factory\CoachFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ManagerFactory::createMany(5);
        ClubFactory::createMany(2);
        CategoryFactory::createOne();
        TeamFactory::createMany(5);
        PlayerFactory::createMany(50);
        CoachFactory::createMany(10);
        $manager->flush();
    }
}
