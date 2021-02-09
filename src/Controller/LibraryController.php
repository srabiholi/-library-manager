<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library/{id}", name="library")
     */
    public function index(LibraryRepository $repository, Library $library, SessionInterface $session): Response
    {

        $user = $this->getUser()->getId();
        $library = $repository->findOneBy(['user' => $user, 'id' =>$library]);

        $session->set('library', $library);
        $sessionLibrary = $session->get('library', $library);
        // dump($sessionLibrary);
        // dump($session->get('library'));
        

        return $this->render('library/index.html.twig', [
            'library' => $sessionLibrary,
        ]);
    }


}
