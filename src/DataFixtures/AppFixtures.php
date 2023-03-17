<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use App\Entity\Brand;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i=0 ; $i <20; $i++){
            $brand = new Brand();
            $brand->setName("Nom" . $i);
            $manager->persist($brand);
            $listBrand[] = $brand;
        }

        for ($i=0 ; $i <20; $i++){
            $mobile = new Mobile();
            $mobile->setModel("Modele" . $i);
            $mobile->setBrand("Marque" . $i);
            $mobile->setBrandId($listBrand[array_rand($listBrand)]);
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}

