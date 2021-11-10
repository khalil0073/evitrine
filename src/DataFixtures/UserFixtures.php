<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User ();
        $manager->persist($user);
        for ($i=0; $i <=10 ; $i++) {
            $user = new User();
            $user->setUsername("username $i")
            ->setEmail($i*10+5)
            ->setPassword("");
            $manager->persist($user);
            }
            

        $manager->flush();
    }
}
