<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 13/12/2018
 * Time: 10:05
 */

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Thread;
use App\Entity\Topic;
use App\Entity\User;
use App\Form\PostFormType;
use App\Form\ThreadFormType;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class ThreadController extends Controller
{
    /**
     *
     * @Route("/forum/{name}/thread=create", name="create_thread")
     *
     */
    public function createThread(Request $request, Session $session, Topic $topic) {

        $thread = new Thread();
        $post = new Post();
        $date = new \DateTime();
        $date->format('Y-m-d H:i:s');
        $thread->setDate($date);
        $post->setDate($date);

        $form = $this->createForm(PostFormType::class, $post, ['standalone' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $thread->setName($post->getThread()->getName());
            $thread->setUsers($this->getUser());
            $thread->setTopic($topic);
            $post->setUser($this->getUser());
            $post->setThread($thread);
            $manager = $this->getDoctrine()->getManager();
            $topic->addThread($thread);
            $thread->addPost($post);
            $manager->persist($thread);
            $manager->persist($post);
            $manager->flush();

            return $this->redirect('/forum/' . $thread->getTopic()->getLabel());

        }

        return $this->render(
            'threadCreate.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}