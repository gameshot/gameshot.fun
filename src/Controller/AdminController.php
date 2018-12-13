<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controller for admin page JP */

class AdminController extends Controller
{

    /**
     *
     * @Route("/admin", name="admin")
     *
     */
    public function admin(){
        return $this->render('user/Admin.html.twig');
    }
}