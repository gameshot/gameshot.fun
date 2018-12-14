<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\Thread;
use App\Entity\User;
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
    public function admin()
    {
        if (!is_null($this->getUser())) {
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                $manager = $this->getDoctrine()->getManager();
                $posts = $manager->getRepository(Post::class)->findAll();
                $users = $manager->getRepository(User::class)->findAll();
                $threads = $manager->getRepository(Thread::class)->findAll();
                $threadAmount = count($threads);
                $userAmount = count($users);
                $postAmount = count($posts);
                return $this->render(
                    'Admin/Admin.html.twig',
                    [
                        'postAmount' => $postAmount,
                        'userAmount' => $userAmount,
                        'threadAmount' => $threadAmount
                    ]
                );
            } else {
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->redirectToRoute('homepage');
    }
}