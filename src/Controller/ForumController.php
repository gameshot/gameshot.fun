<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Thread;
use App\Entity\Topic;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ForumController extends Controller
{
    
    /**
     *
     * @Route("/forum", name="forum")
     *
     */
    public function forum(){
        $manager = $this->getDoctrine()->getManager();
        $categoryList = [];
        $topicList = [];
        $topics = $manager->getRepository(Topic::class)->findAll();
        foreach ($topics as $topic) {
            if (!in_array($topic->getCategory()->getName(), $categoryList)) {
                $categoryList[] = $topic->getCategory()->getName();
            }
            $topicList[$topic->getCategory()->getName()][] = $topic->getName();
        }
        return $this->render(
            'forum.html.twig',
            [
                'topics' => $topics,
                'topicList' => $topicList
            ]
        );
    }

    /**
     * @Route("forum/{name}", name="topic_display")
     */
    public function topicDisplay(Topic $topic) {
        $manager = $this->getDoctrine()->getManager();
        $threads = $manager->getRepository(Thread::class)->findByTopic($topic);
        return $this->render(
            'thread.html.twig',
            [
                'threads' => $threads
            ]
        );
    }

    /**
     * @Route("forum/{name}/thread/{thread}"), name="post_display")
     */
    public function displayPost(Request $request, Topic $topic, Thread $thread) {
        $manager = $this->getDoctrine()->getManager();
        $post = new Post();
        $date = new \DateTime();
        $date->format('Y-m-d H:i:s');
        $post->setDate($date);

        $form = $this->createForm(PostFormType::class, $post, ['standalone' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setThread($thread);
            $post->setUser($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirect('/forum/' . $thread->getTopic()->getLabel() . '/thread/' . $thread->getId());
        }

        $posts = $manager->getRepository(Post::class)->findByThread($thread);
        return $this->render(
            'post.html.twig',
            [
                'posts' => $posts,
                'form' => $form->createView()
            ]
        );
    }
}

