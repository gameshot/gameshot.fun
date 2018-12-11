<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controler for disclaimer page JP */

class DisclaimerController extends Controller
{

    /**
     *
     * @Route("/disclaimer", name="disclaimer")
     *
     */
    public function disclaimer(){
        return $this->render('disclaimer.html.twig');
    }
}

