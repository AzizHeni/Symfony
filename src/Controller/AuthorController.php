<?php

namespace App\Controller;
use App\Entity\Author;
use App\Form\AuthorType; // attention au nom !
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;

final class AuthorController extends AbstractController
{
    

    // === Affichage d'un auteur selon son nom (ex: /show/Victor Hugo)
    #[Route('/show/{name}', name: 'show_author_by_name')]
    public function showAuthorByName(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'nom' => $name
        ]);
    }

    /* === Liste complète d'auteurs (ex: /authors)
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
*/
 #[Route('/author/new', name: 'author_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();

        // Correction du nom de la classe de formulaire
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('app_author_list');
        }

        return $this->render('author/new.html.twig', [
            'form' => $form->createView(), // il manquait les parenthèses
        ]);
    }

    // ----------------modifier------------------

#[Route('/author/edit/{id}', name: 'author_edit')]
public function edit(Request $request, Author $author, EntityManagerInterface $em): Response
{
    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('app_author_list');
    }

    return $this->render('author/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}
//-----------------Delete---------------ù
#[Route('/author/delete/{id}', name: 'author_delete')]
public function delete( Author $author, EntityManagerInterface $em) :Response
{
                    $em->remove($author);
                    $em->flush();
                     return $this->RedirectToRoute('app_author_list');


}















    //--------------------------------- Liste------------------------
#[Route('/authors', name: 'app_author_list')]
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }
    #[Route('/add-author', name: 'app_add_author')]
    public function addAuthor(EntityManagerInterface $em): Response
    {
        // 1️⃣ Créer un nouvel auteur (données statiques)
        $author = new Author();
        $author->setUsername('jobran khalil');
        $author->setEmail('jobran.khalil@example.com');

        // 2️⃣ Persister l’objet (préparer l’insertion)
        $em->persist($author);

        // 3️⃣ Exécuter la requête SQL (INSERT INTO author …)
        $em->flush();

        // 4️⃣ Retourner un message
        return new Response('Auteur ajouté avec succès : ' . $author->getUsername());
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
