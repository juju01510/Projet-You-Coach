<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\CategoryFactory;
use App\Factory\ClubFactory;
use App\Factory\SportFactory;
use App\Factory\TeamFactory;
use App\Factory\TrainingFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createOne();
        ClubFactory::createOne();
        SportFactory::createOne();
        TeamFactory::createOne();
        TrainingFactory::createOne();
        UserFactory::createOne();
        $manager->flush();
    }
}
