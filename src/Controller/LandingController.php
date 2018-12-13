<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controller for about page JP */

class LandingController extends Controller
{
    
    /**
     *
     * @Route("/landing", name="landing")
     *
     */
    public function landing(){
        return $this->render('landing.html.twig');
    }
}

