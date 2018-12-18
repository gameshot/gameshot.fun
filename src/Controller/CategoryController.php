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
    public function categoryCreate(Request $request)
    {
        if (!is_null($this->getUser())) { // Check user registration
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) { // Check role attribution
                $category = new Category();  // Creates a new category
                $form = $this->createForm(CategoryFormType::class, $category, ['standalone' => true]); // Create the form
                $form->handleRequest($request); // Handles the form request

                if ($form->isSubmitted() && $form->isValid()) { // Check if the form is submitted and valid
                    $manager = $this->getDoctrine()->getManager(); // Get the manager
                    $manager->persist($category); // Persist the entity category
                    $manager->flush(); // Flush to the database
                    return $this->redirectToRoute('admin'); // Redirect to admin page
                }

                return $this->render( // Shows the page rendering
                    'Admin/CreateCategory.html.twig', // Redirects to the template
                    [
                        'form' => $form->createView() // Sends the form to twig
                    ]
                );
            } else {
                return $this->redirectToRoute('homepage'); // If user role is not admin , redirects to homepage
            }
        }
        return $this->redirectToRoute('homepage'); // If not registered redirects to homepage

    }
}