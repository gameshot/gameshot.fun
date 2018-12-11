<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController
{
    
    private $twig;
    
    public function __construct(
        \Twig_Environment $twig
        )
    {
        $this->twig = $twig;
    }
    /**
     * The home page of the application
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
             
        return new Response(
            $this->twig->render('landing.html.twig'));
    }
}

