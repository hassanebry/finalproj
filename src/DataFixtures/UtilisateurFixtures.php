<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UtilisateurFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();
        $user->setEmail("user@user.fr");
        $user->setNom("user");
        $user->setPrenom("user");
        $user->setTelephone("12345678");
        $user->setAdresse("123 rue test");
        $user->setVille("testville");
        $user->setCodePostal("44300");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $manager->persist($user);

        $admin = new Utilisateur();
        $admin->setEmail("admin@admin.fr");
        $admin->setNom("user");
        $admin->setPrenom("user");
        $admin->setTelephone("12345678");
        $admin->setAdresse("123 rue test");
        $admin->setVille("testville");
        $admin->setCodePostal("44300");
        $admin->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();

    }
}