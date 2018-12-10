<?php
namespace App\Controller;

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
        return $this->render('forum.html.twig');
    }
}

