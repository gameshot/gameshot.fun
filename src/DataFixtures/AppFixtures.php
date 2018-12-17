<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 11/12/2018
 * Time: 10:24
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Role;
use App\Entity\Thread;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->loadAll($manager);

        $manager->flush();
    }

    public function loadAll(ObjectManager $manager)
    {
        $roleList = [
            'ROLE_USER',
            'ROLE_ADMIN'
        ];

        foreach ($roleList as $roleLabel) {
            $role = new Role();
            $role->setLabel($roleLabel);
            $manager->persist($role);
        }

        $categoryList = [
            'Gameshot',
            'Games'
        ];
        $topicList = [
            'Discussion',
            'Bugs',
            'Tutorials'
        ];

        $threadList = [
            'stuff1',
            'stuff2',
            'stuff3'
        ];

        $postList = [
            'test',
            'loremu',
            'lurem'
        ];

        $date = new \DateTime();
        $date->format('Y-m-d H:i:s');

        $user = new User();
        $user->setRoles($role);
        $user->setUsername('admin');
        $user->setEmail('admin@admin.admin');
        $user->setSalt(md5($user->getUsername()));
        $user->setPassword('admin');
        $user->setVerified(true);

        foreach ($categoryList as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            foreach ($topicList as $topicName)
            {
                $topic = new Topic();
                $topic->setName($topicName);
                $category->addTopic($topic);
                foreach ($threadList as $threadName) {
                    $thread = new Thread();
                    $thread->setName($threadName);
                    $thread->setUsers($user);
                    $thread->setTopic($topic);
                    $thread->setDate($date);
                    foreach ($postList as $postContent) {
                        $post = new Post();
                        $post->setContent($postContent);
                        $post->setDate($date);
                        $post->setThread($thread);
                        $post->setUser($user);
                        $manager->persist($post);
                    }
                    $manager->persist($thread);
                }
                $manager->persist($topic);
            }
            $manager->persist($category);
        }
    }

}