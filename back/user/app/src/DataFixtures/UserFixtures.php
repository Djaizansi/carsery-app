<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.

        $user = (new User())
            ->setAddress($this->getReference(0))
            ->setEmail('manbou92@hotmail.fr')
            ->setRoles(array("ROLE_CLIENT"))
            ->setPassword('123')
            ->setFirstname('Marwane')
            ->setLastname('BOUABDELLAH')
            ->setGender('M')
            ->setType("customer")
            ->setTokenAccount(null);

        $manager->persist($user);
        $manager->flush();

        $userPro = (new User())
            ->setAddress($this->getReference(1))
            ->setEmail('youcef.jallali@hotmail.fr')
            ->setRoles(array("ROLE_PRO"))
            ->setPassword('123')
            ->setFirstname('Youcef')
            ->setLastname('JALLALI')
            ->setGender('M')
            ->setCompany("IBM")
            ->setSiret("12356894100056")
            ->setType("pro")
            ->setTokenAccount(null);
        $manager->persist($userPro);
        $manager->flush();

        $userAdmin = (new User())
            ->setAddress($this->getReference(2))
            ->setEmail('youcef.jallali+admin@hotmail.fr')
            ->setRoles(array("ROLE_ADMIN"))
            ->setPassword('123')
            ->setFirstname('Youcef')
            ->setLastname('JALLALI')
            ->setCompany("Djaisanzi")
            ->setSiret("12356894100056")
            ->setGender('M')
            ->setType("admin")
            ->setTokenAccount(null);

        $manager->persist($userAdmin);
        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class
        ];
    }
}