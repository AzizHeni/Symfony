<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\choicetype;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType; // attention au nom !

use Symfony\Component\Form\FormBuilderInterface;



final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/add' , name : 'addbook')]
    public function add(EntityManagerInterface $em, Request $request ) : Response
    {
        $book =new Book();
        $book->setPublished(true);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid())
        {
             $author=$book->getAuthor();
            $author->setNbBooks($author->getNbBooks() + 1);
            $em->persist($book);
            $em->persist($author);
            $em->flush();
    return $this->redirectToRoute('app_book');        

    }
    return $this->render('book/add.html.twig', [ 'form'=> $form->createView(),]);
    
}
}