<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    const TAGS = [
        'Vegan',
        'Healthy',
        'Familial',
        'Carnivore',
        'Oriental',
        'Epicé'
    ];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 6; $i++) {
            $tag = new Tag();
            $tag->setName(self::TAGS[$i]);
            $manager->persist($tag);
            $this->addReference('tag_' . self::TAGS[$i], $tag);
        }
        $manager->flush();
    }
}
