<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
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
    public function index(Request $request, SessionInterface $session): Response
    {

        $sessionLibrary = $session->get('library');
        // dump($sessionLibrary);


        $book = new Book;

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
        }

        return $this->render('library/add.html.twig', [
            'form' => $form->createView(),
            'library' => $sessionLibrary,
        ]);
    }
}