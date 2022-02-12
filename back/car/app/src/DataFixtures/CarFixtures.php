<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.

        $car = (new Car())
            ->setUser(1)
            ->setPower(400)
            ->setStatusAdminCar("ok")
            ->setStatus(0)
            ->setModel($this->getReference(ModelFixtures::MODEL_REFERENCE))
            ->setNumberplate("DH-301-MH")
            ->setDateRegistration(date_create('2018-01-01'))
            ->setKilometer(120000)
            ->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE))
            ->setTypeCarUser("test")
            ->setColor('#0000')
            ->setPrice(120);

        $manager->persist($car);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModelFixtures::class,
            CategoryFixtures::class,
        ];
    }
}