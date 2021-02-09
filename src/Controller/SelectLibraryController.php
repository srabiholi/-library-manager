<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SelectLibraryController extends AbstractController
{

    /**
     * @Route("/library", name="library_edit")
     * 
     */
    public function library(Request $request, EntityManagerInterface $entityManager)
    {

        $user = $this->getUser();

        $library = new Library;
        
        if($request->request->count() > 0){
            $library->setName($request->request->get('library'));
            $library->setUser($user);
        }
        
        $entityManager->persist($library);
        $entityManager->flush();


            return $this->redirectToRoute('library', ['id' => $library->getId() ]);


    }


    /**
     * @Route("/select/library", name="select_library")
     */
    public function index(LibraryRepository $repository, SessionInterface $session): Response
    {
        
        $sessionLibrary = $session->get('library', []);
        // dump($sessionLibrary);
        if(!empty($sessionLibrary)) {
            unset($sessionLibrary);
        }

        $user = $this->getUser()->getId();

        $librarys = $repository->findBy(['user' => $user]);


        return $this->render('select_library/index.html.twig', [
            'librarys' => $librarys,
        ]);
    }


}
