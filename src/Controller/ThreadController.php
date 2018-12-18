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
use App\Form\PostFormType;
use EN\IgdbApiBundle\Igdb\IgdbWrapperInterface;
use EN\IgdbApiBundle\Igdb\Parameter\ParameterBuilderInterface;
use EN\IgdbApiBundle\Igdb\ValidEndpoints;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends Controller
{
    /**
     *
     * @Route("/forum/{name}/thread=create", name="create_thread")
     *
     */
    public function createThread(Request $request, Session $session, Topic $topic)
    {
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

            return $this->redirect('/forum/' . strtolower($thread->getTopic()->getName()));

        }

        return $this->render(
            'threadCreate.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}