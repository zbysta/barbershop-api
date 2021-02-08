<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Position();
            $product->setName('position '.$i);
            
            $manager->persist($product);
        }

        $appUser = new AppUser();
        $appUser->setEmail('user1@example.com');
        $appUser->setPassword('$argon2i$v=19$m=65536,t=4,p=1$M0xPNkpsaUs2L3BkeWVZOQ$kLmoWt2n6j8xjcx5yPJH07tQGsGOPYdj3Kfa4dhoZAk'); //haslo111
                
        $manager->persist($appUser);
        
        $manager->flush();
    }
}
