<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\House;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class HouseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for($c=0;$c<10;$c++) {
            $city = new City();
            $city ->setName($faker->city);
            $manager->persist($city);

            for($h=0;$h<10;$h++) {
                $house = new House();
                $house->setNomination('Très belle<br> maison de ville')
                    ->setImage('/assets/images/maison.jpg')
                    ->setPrice($faker->randomFloat(2, 100000, 1000000))
                    ->setDescription($faker->paragraphs(3, true))
                    ->setCity($city);
                $manager->persist($house);
            }
        }



        $manager->flush();
    }
}
