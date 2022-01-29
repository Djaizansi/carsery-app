<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $modelCsv = fopen("public/csv/modeles.csv", "r");
        $header = fgetcsv($modelCsv,10000,';');
        $modelIndex = array_search('modele',$header);
        $brandIndex = array_search('rappel_marque',$header);
        while (($line = fgetcsv($modelCsv,10000,';')) !== FALSE) {
            if($line[$modelIndex] === "modele") continue;
            $brand = $manager->getRepository(Brand::class)->findBy(['name'=>$line[$brandIndex]])[0];
            $model = new Model();
            $model->setName($line[$modelIndex]);
            $model->setBrand($brand);
            $manager->persist($model);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BrandFixtures::class
        ];
    }
}
