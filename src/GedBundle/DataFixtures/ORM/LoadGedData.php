<?php
// src/GedBundle/DataFixtures/ORM/LoadGedData.php
// loading fixtures: doctrine:fixtures:load (--append)

namespace GedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
//use GedBundle\Entity\Documents;
use UserBundle\Entity\User;

class LoadGedData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

    }
}