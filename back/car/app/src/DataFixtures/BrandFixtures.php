<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brandCsv = fopen("public/csv/marques.csv", "r");
        $header = fgetcsv($brandCsv,10000,';');
        $brandIndex = array_search('marque',$header);
        while (($line = fgetcsv($brandCsv,10000,';')) !== FALSE) {
            if($line[$brandIndex] === "marque") continue;
            $brand = new Brand();
            $brand->setName($line[$brandIndex]);
            $manager->persist($brand);
        }
        $manager->flush();
    }
}
