<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 17/12/2018
 * Time: 11:51
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends Controller
{
    /**
     *
     *@Route("/verification/user={id}", name="verification")
     *
     */
    public function register(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $user->setVerified(true);
        $manager->persist($user);
        $manager->flush();
        return $this->render(
            'MailVerification.html.twig'
        );
    }
}