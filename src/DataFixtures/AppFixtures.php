<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Compagny;
use App\Entity\customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0;$i < 30;$i++)
        {
            $customer = (new Customer())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->safeEmail)
                ->setPhone($faker->mobileNumber);
            $manager->persist($customer);
        }

        for($i = 0;$i < 10;$i++)
        {
            $compagny = (new Compagny())
                ->setName($faker->company)
                ->setSiret($faker->siret)
                ->setAddress($faker->streetName)
                ->setZipCode($faker->postcode)
                ->setCity($faker->city);
            $manager->persist($compagny);
        }
        $manager->flush();
    }
}
