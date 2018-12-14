<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* controller for role page JP */

class RoleController extends Controller
{

    /**
     *
     * @Route("/admin/user/role", name="user_role")
     *
     */
    public function role(){
        return $this->render('user/Role.html.twig');
    }
}

