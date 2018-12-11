<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 11/12/2018
 * Time: 10:24
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Role;
use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadRoles($manager);
        $this->loadCategories($manager);

        $manager->flush();
    }

    public function loadRoles(ObjectManager $manager)
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
    }

    public function loadCategories(ObjectManager $manager)
    {
        $categoryList = [
            'Gameshot discussion',
            'Game discussions'
        ];
        $topicList = [
            'Gameshot',
            'Gameshot bugs'
        ];

        foreach ($categoryList as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            foreach ($topicList as $topicName)
            {
                $topic = new Topic();
                $topic->setName($topicName);
                $topic->setCategory($category);
                $manager->persist($topic);
                $category->addTopic($topic);
            }
            $manager->persist($category);
        }
    }

}