<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 14/12/2018
 * Time: 14:32
 */

namespace App\Controller;


use App\Entity\Topic;
use App\Form\TopicFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends Controller
{
    /**
     * @Route("/admin/topic/create", name="topic_create")
     */
    public function topicCreate(Request $request) {
        if (!is_null($this->getUser())) {
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                $topic = new Topic();
                $form = $this->createForm(TopicFormType::class, $topic, ['standalone' => true]);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($topic);
                    $manager->flush();
                    return $this->redirectToRoute('admin');
                }

                return $this->render(
                    'Admin/CreateTopic.html.twig',
                    [
                        'form' => $form->createView()
                    ]
                );
            } else {
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->redirectToRoute('homepage');
    }
}