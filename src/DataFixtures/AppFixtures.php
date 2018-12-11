<?php
/**
 * Created by PhpStorm.
 * User: Stefano P
 * Date: 11/12/2018
 * Time: 10:24
 */

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadRoles($manager);

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
}