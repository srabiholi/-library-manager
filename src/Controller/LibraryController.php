<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\BookRepository;

use App\Repository\LibraryRepository;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library/{id}", name="library")
     */
    public function index(BookRepository $bookRepo, LibraryRepository $repository, Library $library, SessionInterface $session): Response
    {

        $user = $this->getUser()->getId();
        $library = $repository->findOneBy(['user' => $user, 'id' =>$library]);

        $session->set('library', $library);
        $sessionLibrary = $session->get('library', $library);
        // dump($sessionLibrary);
        // dump($session->get('library'));


        
        $books = $bookRepo->findBy(['library' =>$library]);
        dump($books);
        

        return $this->render('library/index.html.twig', [
            'library' => $sessionLibrary,
            'books' => $books,
        ]);
    }


}
