<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use GedBundle\Entity\Documents;

class DocumentsControllerTest extends WebTestCase
{

    public function testChampsAddDoc() {


        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));


        $crawler = $client->request('GET', '/documents');

        $crawler = $client->followRedirect('AppBundle\Controller\DefaultController::indexAction');

        // Tests de la présence des champs
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[titre]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[auteur]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form textarea[name="gedbundle_documents[resume]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][day]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][month]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][year]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[file]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form button[name="gedbundle_documents[submit]"]')->count() == 1);

    }

    public function testUpload()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/documents');
        $crawler = $client->followRedirect();

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $entity = new Documents();

        $document = new UploadedFile(
            '/Users/Florian/Downloads/plaquette structure chateaudun.pdf',
            'plaquette structure chateaudun.pdf',
            'application/pdf'
        );

        $form = $crawler->selectButton('Connexion')->form();

        $form['titre']= 'test';
        $form['auteur']= 'test';
        $form['resume']= 'test';
        $form['file']= $document;

        $crawler = $client->submit($form);

        $em->persist($form);
        $em->flush();

        $crawler = $client->request('GET', '/documents');
        $crawler = $client->followRedirect();

        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction', $client->getRequest()->attributes->get('_controller'));
    }

}
