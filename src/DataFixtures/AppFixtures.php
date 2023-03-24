<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use App\Entity\Brand;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un user "normal"
        $user = new User();
        $user->setEmail("user@bookapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        // Création des auteurs.
        $listBrand = [];
        for ($i = 0; $i < 10; $i++) {
            // Création de l'auteur lui-même.
            $brand = new Brand();
            $brand->setName("Marque " . $i);
            $manager->persist($brand);

            // On sauvegarde l'auteur créé dans un tableau.
            $listBrand[] = $brand;
        }

        for ($i = 0; $i < 20; $i++) {
            $mobile = new Mobile();
            $mobile->setModel("Modèle " . $i);
            $mobile->setBrand($listBrand[array_rand($listBrand)]);
            $manager->persist($mobile);
        }

        $manager->flush();
   }
}

