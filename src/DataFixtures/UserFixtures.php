<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $jeanpierre = UserFactory::createOne(['firstName' => 'Jean-Pierre', 'lastName' => 'Kiroule', 'email' => 'namassepasmousse@gmail.com', 'roles' => ['ROLE_USER']]);
        $realJeanPierre = $jeanpierre->object();
        $password = $this->passwordHasher->hashPassword($realJeanPierre, 'test');
        $realJeanPierre->setPassword($password);

        $henriEdouard = UserFactory::createOne(['firstName' => 'Henri-Edouard', 'lastName' => 'Plastik', 'email' => 'hep@hotmail.com', 'roles' => ['ROLE_ADMIN']]);
        $realHenriEdouard = $henriEdouard->object();
        $password = $this->passwordHasher->hashPassword($realHenriEdouard, 'test');
        $realHenriEdouard->setPassword($password);

        $patrick = UserFactory::createOne(['firstName' => 'Patrick', 'lastName' => 'Patraque', 'email' => 'pp@hotmail.com', 'roles' => ['ROLE_ADMIN']]);
        $realPatrick = $patrick->object();
        $password = $this->passwordHasher->hashPassword($realPatrick, 'test');
        $realPatrick->setPassword($password);

        $manager->persist($realJeanPierre);
        $manager->persist($realHenriEdouard);
        $manager->persist($realPatrick);

        UserFactory::createMany(50, ['roles' => ['ROLE_USER']]);
        UserFactory::createMany(50, ['roles' => ['ROLE_ADMIN']]);
        // Create and persist other users as needed

        $manager->flush();
    }
}
