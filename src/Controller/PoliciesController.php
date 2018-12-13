<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controller for policies page JP */

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

