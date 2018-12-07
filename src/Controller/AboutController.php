<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class AboutController extends Controller
{
    
    /**
     *
     * @Route("/about", name="about")
     *
     */
    public function about(){
        return $this->render('about.html.twig');
    }
}

