<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Topic;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class ForumController extends Controller
{
    
    /**
     *
     * @Route("/forum", name="forum")
     *
     */
    public function forum(){
        $manager = $this->getDoctrine()->getManager();
        $categoryList = $manager->getRepository(Category::class)->findAll();
        return $this->render(
            'forum.html.twig',
            [
                'categoryList' => $categoryList
            ]
        );
    }
}

