<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class GameController extends Controller
{
    
    /**
     *
     * @Route("/game", name="game")
     *
     */
    public function game(){
        return $this->render('game.html.twig');
    }
}

