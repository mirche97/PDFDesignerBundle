<?php

namespace Acme\DemoBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CustomFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // ...
    }
}
