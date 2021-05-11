<?php

namespace App\Domain\DataFixtures;

use App\Domain\Auth\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */

     private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setNom("maester");
        $user->setPassword($this->encoder->encodePassword($user,"maesterpro"));
        $manager->persist($user);
        $manager->flush();
    }
}
