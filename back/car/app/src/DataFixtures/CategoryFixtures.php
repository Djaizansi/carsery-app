<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['SUV','Familiale','Citadine','Cabriolet','Compacte','Break','Berline'];
        shuffle($categories);
        foreach($categories as $category){
            $categoryObj = new Category();
            $categoryObj->setName($category);
            $manager->persist($categoryObj);
        }
        $manager->flush();
    }
}
