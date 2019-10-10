<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('kevin@codev-web.fr')
            ->setUsername('BobGizzmo')
            ->setPassword('$2y$10$OoD85sYnuAZonPGanCQCHO11yJhH8CMveybVCPoDT1Nq37.APc2Ym')
            ->setRoles(['ROLE_ADMIN']);
        
            $manager->persist($user);

        $user = new User();
        $user->setEmail('demo@admin.demo')
        ->setUsername('demo')
        ->setPassword('$2y$10$OoD85sYnuAZonPGanCQCHO11yJhH8CMveybVCPoDT1Nq37.APc2Ym')
        ->setRoles(['ROLE_ADMIN']);
    
        $manager->persist($user);

        
        $user = new User();
        $user->setEmail('demo@user.demo')
            ->setUsername('demo')
            ->setPassword('$2y$10$OoD85sYnuAZonPGanCQCHO11yJhH8CMveybVCPoDT1Nq37.APc2Ym')
            ->setRoles(['ROLE_USER']);
        
            $manager->persist($user);

        $manager->flush();
    }
}
