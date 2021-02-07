<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library/{id}", name="library")
     */
    public function index(LibraryRepository $repository, Library $library): Response
    {

        $user = $this->getUser()->getId();

        $library = $repository->findOneBy(['user' => $user, 'id' =>$library]);

        // dump($library);

        return $this->render('library/index.html.twig', [
            'library' => $library,
        ]);
    }


}
