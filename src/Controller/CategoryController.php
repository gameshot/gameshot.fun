<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 14/12/2018
 * Time: 14:14
 */

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function categoryCreate(Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category, ['standalone' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin');
        }

        return $this->render(
            'Admin/CreateCategory.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}