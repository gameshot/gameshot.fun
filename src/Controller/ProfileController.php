<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends Controller
{
    
    /**
     *
     * @Route("/profile", name="profile")
     *
     */
    public function profile(){
        return $this->render('profile.html.twig');
    }
}

