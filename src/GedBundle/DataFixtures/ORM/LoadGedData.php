<?php
//// src/GedBundle/DataFixtures/ORM/LoadGedData.php
//// loading fixtures: doctrine:fixtures:load (--append)
//
//namespace GedBundle\DataFixtures\ORM;
//
//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use GedBundle\Entity\Documents;
//use Doctrine\Common\DataFixtures\AbstractFixture;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Symfony\Component\HttpFoundation\File\File;
//use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//
//class DocumentsFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
//{
//    public function load(ObjectManager $manager)
//    {
//        $document = new Documents();
//        $file = new File($document->getFixturesPath() . 'plaquette structure chateaudun (1).pdf');
//        $document->setTitre('Test document');
//        $document->setResume('Test upload document');
//        $document->setFileName('test_upload.pdf');
//
//        $document->setFileName('file_test.php');
//        $document->setDocument(uniqid().'.'.$file->guessExtension());
//
//        $manager->persist($document);
//        $manager->flush();
//    }
//
//    public function getOrder()
//    {
//        return 2;
//    }
//}