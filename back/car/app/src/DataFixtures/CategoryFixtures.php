<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category-ref';

    public function load(ObjectManager $manager): void
    {
        $categories = ['SUV','Familiale','Citadine','Cabriolet','Compacte','Break','Berline','Coupé'];
        shuffle($categories);
        foreach($categories as $category){
            $categoryObj = new Category();
            $categoryObj->setName($category);
            $manager->persist($categoryObj);
        }
        $manager->flush();
        $this->setReference(self::CATEGORY_REFERENCE, $categoryObj);
    }
}
