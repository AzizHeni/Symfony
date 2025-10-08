<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    // === Affichage d'un auteur selon son nom (ex: /show/Victor Hugo)
    #[Route('/show/{name}', name: 'show_author_by_name')]
    public function showAuthorByName(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'nom' => $name
        ]);
    }

    // === Liste complète d'auteurs (ex: /authors)
    #[Route('/authors', name: 'authors_list')]
    public function listAuthors(): Response
    {
        $authors = [
            [
                'id' => 1,
                'picture' => '/images/image1.jfif',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ],
            [
                'id' => 2,
                'picture' => '/images/image2.jfif',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ],
            [
                'id' => 3,
                'picture' => '/images/image3.jfif',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            ],
        ];

        return $this->render('author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    // === Page de détails d’un auteur via son ID (ex: /author/2)
    #[Route('/author/{id}', name: 'author_show')]
    public function showAuthorById(int $id): Response
    {
        $authors = [
            1 => [
                'id' => 1,
                'picture' => '/images/image1.jfif',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ],
            2 => [
                'id' => 2,
                'picture' => '/images/image2.jfif',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ],
            3 => [
                'id' => 3,
                'picture' => '/images/image3.jfif',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            ],
        ];

        $author = $authors[$id] ?? null;

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author
        ]);
    }
}
