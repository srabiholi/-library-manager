<?php

namespace App\Controller;

use App\Entity\Library;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
 * @Route("/{library}/category/", name="category_")
 */
class CategoryController extends AbstractController
{

     /**
     * @Route("create", name="create")
     */
    public function create(Library $library, Request $request): Response
    {
        $category = new Category;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category->setLibrary($library);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('book_create', ['library' => $library->getId() ]);
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}