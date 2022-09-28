<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Professeur;
use App\Entity\Etablissement;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EtablissementFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
}

    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<5;$i++){
            $etab = new Etablissement();
            $etab->setNom($this->faker->lastName())
            ->setType($this->faker->catchPhrase())
            ->setReferent($this->getReference('prof'.mt_rand(0,49)));
            $this->addReference('etab'.$i, $etab);
            $manager->persist($etab);
            for($j=0;$j<mt_rand(10,49);$j++){
                $prof = $this->getReference('prof'.$j);
                $prof -> addEtablissement($this->getReference('etab'.$i));
                $manager->persist($prof);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfesseurFixtures::class,
        ];
    }
}