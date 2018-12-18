<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\Thread;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/* Controller for admin page JP */

class AdminController extends Controller
{

    /**
     *
     * @Route("/admin", name="admin")
     *
     */
    public function admin()
    {
        if (!is_null($this->getUser())) { // User verification regarding if exists
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) { // Role check for admin
                $manager = $this->getDoctrine()->getManager(); // Get manager
                $posts = $manager->getRepository(Post::class)->findAll(); // Get all the posts from repository
                $users = $manager->getRepository(User::class)->findAll(); // Get all the users from repository
                $threads = $manager->getRepository(Thread::class)->findAll(); // get all the threads from repository
                $threadAmount = count($threads); // Amount of threads reg in database
                $userAmount = count($users); // Amount of users reg in database
                $postAmount = count($posts); // Amount of posts reg in database
                return $this->render( // Renders the page to display the results
                    'Admin/Admin.html.twig', // Twig template in use to render the results
                    [
                        'postAmount' => $postAmount, // Result being sent to twig page
                        'userAmount' => $userAmount, //
                        'threadAmount' => $threadAmount //
                    ]
                );
            } else {
                return $this->redirectToRoute('homepage'); // If role is User redirects to homepage
            }
        }
        return $this->redirectToRoute('homepage'); // If anonymous or not reg redirects to homepage
    }
}