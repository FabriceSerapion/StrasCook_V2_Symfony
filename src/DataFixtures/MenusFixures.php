<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class MenusFixures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $menu = new Menu();
            $menu->setName($faker->words(3, true));
            $menu->setPrice($faker->randomNumber(4, false));
            $menu->setRating($faker->numberBetween(1, 5));
            $menu->setDescrAppetizer($faker->sentences(1, true));
            $menu->setDescrCheese($faker->sentences(2, true));
            $menu->setDescrCuteness($faker->sentences(1, true));
            $menu->setDescrDessert($faker->sentences(2, true));
            $menu->setDescrMeal($faker->sentences(3, true));
            $menu->setDescrStarter($faker->sentences(2, true));
            $menu->addTag($this->getReference(
                'tag_' . TagFixtures::TAGS[rand(0, 5)]
            ));
            $manager->persist($menu);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return  [
            TagFixtures::class
        ];
    }
}
