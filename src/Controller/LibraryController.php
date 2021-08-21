<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\BookRepository;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/library/", name="library_")
 */
class LibraryController extends AbstractController
{
    
    /**
     * @Route("{id}", name="show")
     */
    public function show(BookRepository $bookRepo, LibraryRepository $repository, Library $library): Response
    {

        $library = $repository->findOneBy(['user' => $this->getUser()->getId(), 'id' =>$library]);
        $books = $bookRepo->findBy(['library' =>$library]);

        return $this->render('library/show.html.twig', [
            'library' => $library,
            'books' => $books,
        ]);
    }

    /**
     * @Route("create", name="create", priority=2)
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $library = new Library;

        if($request->request->count() > 0){
            $library->setName($request->request->get('library'));
            $library->setUser($this->getUser());
        }
        
        $entityManager->persist($library);
        $entityManager->flush();
 
        return $this->redirectToRoute('library_show', ['id' => $library->getId() ]);
    }


    /**
     * @Route(" ", name="list")
     */
    public function index(LibraryRepository $repository): Response
    {
        $librarys = $repository->findBy(['user' => $this->getUser()->getId()]);

        return $this->render('library/index.html.twig', [
            'librarys' => $librarys,
        ]);
    }

}
