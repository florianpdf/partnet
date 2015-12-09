<?php
// src/GedBundle/DataFixtures/ORM/LoadGedData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace GedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use GedBundle\Entity\Documents;

class LoadGedData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // First, delete all files in app/uploads/documents
        array_map('unlink', glob("app/uploads/documents/*.pdf"));

        $document = new Documents();
        $document->setTitre('Test document');
        $document->setUser($this->getReference('uploader'));
        $document->setAuteur('test_upload.pdf');
        $document->setResume('Test upload document');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/01/2015'));
        $document->setFinDeVie(new \DateTime('01/01/2016'));
        $manager->persist($document);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
