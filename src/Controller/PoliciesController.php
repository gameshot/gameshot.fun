<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controler for policies page JP */

class PoliciesController extends Controller
{

    /**
     *
     * @Route("/policies", name="policies")
     *
     */
    public function policies(){
        return $this->render('policies.html.twig');
    }
}

