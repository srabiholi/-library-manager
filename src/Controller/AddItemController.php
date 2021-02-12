<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddItemController extends AbstractController
{
    /**
     * @Route("/add/book", name="add_book")
     */
    public function index(LibraryRepository $repository, Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {

        $sessionLibrary = $session->get('library');
        // dump($sessionLibrary);

        $library = $repository->findOneBy(['id' =>$sessionLibrary]);
        // dump($library);

        $book = new Book;

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $book->setLibrary($library);
            
            $entityManager->persist($book);
            $entityManager->flush();
            
            return $this->redirectToRoute('library', ['id' => $library->getId() ]);
        }



        return $this->render('library/add.html.twig', [
            'form' => $form->createView(),
            'library' => $sessionLibrary,
        ]);
    }
}
