<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends Controller
{
    
    /**
     *
     * @Route("/profil", name="profil")
     *
     */
    public function profil(){
        return $this->render('profil.html.twig');
    }
}

