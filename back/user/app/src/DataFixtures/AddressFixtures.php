<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $city = ['Gennevilliers', 'Paris', 'Aubervilliers'];
        $street = ['2 rue Croix des vignes', '15 Aller de Nation', "34 rue de Jeanne d'Arc"];
        $code = ['92230', '75012', '93239'];


        for ($i=0;$i<3;$i++) {
            $address = (new Address())
                ->setCity($city[$i])
                ->setPostalCode($code[$i])
                ->setCountry('France')
                ->setStreet($street[$i])
                ->setRegion('Ile-De-France');

            $manager->persist($address);
            $this->addReference($i, $address);
        }
        $manager->flush();
    }
}