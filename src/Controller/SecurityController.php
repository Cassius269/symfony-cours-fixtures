<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Author;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route(
        path: '/inscription',
        name: 'inscription',
        methods: ['GET', 'POST']
    )]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Créer le formulaire
        $author = new Author;

        $form = $this->createForm(UserType::class, $author);

        // Recuillir la requête
        $form->handleRequest($request);

        // Vérifier le formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());// Afficher les données saisies
            // Hacher le mot de passe saisi
            $plainTextPassword = $form['password']->getData();
            $hashedPassword = $passwordHasher->hashPassword($author, $plainTextPassword);

            // Ajouter les données manquantes à l'objet user des informations saisies par l'utilisateur
            $author->setRoles(['ROLE_AUTHOR'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword($hashedPassword);

            // Envoyer les données en base de donnée via l'entité manager de  Doctrine
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            // Rediriger l'utilisateur à la page d'accueil
            $this->addFlash('success', 'Votre compte a été créé'); // Emettre un message flash de succès d'inscription
            return $this->redirectToRoute('home'); // Rediriger à la page d'accueil de l'application
        }
        // Afficher la vue du formulaire

        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route(
        path: '/connexion',
        name: 'connexion',
        methods: ['GET', 'POST']
    )]
    public function connect(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        // Si un utilisateur est déjà connecté 
        if ($this->getUser()) {
            return $this->redirectToRoute('home'); // Rediriger à la page d'accueil
        }

        // Si une erreur est survenue, émettre un message flash
        if ($error) {
            $this->addFlash('error', 'Une erreur s\'est produite');
        }

        return $this->render('security/connexion.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }


    #[Route(
        path: '/logout',
        name: 'logout'
    )]
    public function logout() {}
}
