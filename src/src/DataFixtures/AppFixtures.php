<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\joke;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $joke = new Joke();
            $joke->setName('Joke '  . $i);
            $joke->setContent(str_repeat('Content ', rand(5, 20)));
            $manager->persist($joke);
        }

        $manager->flush();
    }
}
