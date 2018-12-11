<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class PhaserController extends Controller
{

    /**
     *
     * @Route("/phaser", name="phaser")
     *
     */
    public function phaser(){
        return $this->render('phaser.html.twig');
    }
}

