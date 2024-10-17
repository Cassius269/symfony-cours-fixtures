<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthorFixtures extends Fixture
{
    // Injection de la dépendance de hashage de mot de passe d'un utilisateur
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Déclarer un objet auteur
        $author = new Author;

        // Hasher le mot de passer
        $author->setFirstname('Jean')
            ->setLastname('Dupont')
            ->setRoles(['ROLE_AUTHOR'])
            ->setEmail('jean.dupont@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($author, '1234'))
            ->setCreatedAt(new \DateTimeImmutable());

        // Envoyer l'objet auteur nouvellement créé en BDD
        $manager->persist($author);
        $manager->flush();
    }
}
