<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Topic;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
        $threadList = [];
        $threads = 'test';
        return $this->render(
            'thread.html.twig',
            [
                'threads' => $threads
            ]
        );
    }
}

