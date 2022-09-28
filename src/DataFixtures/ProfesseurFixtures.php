<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Professeur;

class ProfesseurFixtures extends Fixture
{
    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
}

    public function load(ObjectManager $manager): void
    {

        for($i=0;$i<50;$i++){
            $prof = new Professeur();
            $prof->setNom($this->faker->lastName())
            ->setPrenom($this->faker->firstName())
            ->setVille($this->faker->city())
            ->setRue($this->faker->streetAddress())
            ->setCodepostal($this->faker->postcode());
            $this->addReference('prof'.$i, $prof);
            $manager->persist($prof);
        }
        $manager->flush();
    }
}