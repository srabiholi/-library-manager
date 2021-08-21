<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Library;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("{library}/book/", name="book_")
 */
class BookController extends AbstractController
{

    /**
     * @Route("list", name="list")
     */
    public function index(Library $library, BookRepository $bookRepository)
    {
        $books = $bookRepository->findBy(['library' => $library]);

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    
    }

    /**
     * @Route("create", name="create")
     */
    public function create(Library $library, Request $request, EntityManagerInterface $em)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book, ['id' => $library->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $book->setLibrary($library);

            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('library_show', ['id' => $library->getId()]);
        }

        return $this->render('library/createBook.html.twig', [
            'library' => $library,
            'form' => $form->createView()
        ]);
    
    }

    /**
     * @Route("{id}", name="show")
     */
    public function show(Book $book)
    {
        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    
    }
} 