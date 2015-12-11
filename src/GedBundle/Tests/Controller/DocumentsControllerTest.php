<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use GedBundle\Entity\Documents;

class DocumentsControllerTest extends WebTestCase
{
    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU4ADMINISTRATEUR //


    // Verification de la présence des champs dans le formulaire
    public function testChampsAddDoc() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/documents/nouveau');

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

    // Test du formulaire d'upload
    public function testFormAddValid()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        // Définition du formulaire
        $form = $crawler->selectButton('Envoyer')->form(array(
            'gedbundle_documents[titre]' => 'Test upload',
            'gedbundle_documents[auteur]' => 'Test upload auteur',
            'gedbundle_documents[resume]' => 'Ceci est un test d\'upload',
            'gedbundle_documents[finDeVie][day]' => 1,
            'gedbundle_documents[finDeVie][month]' => 1,
            'gedbundle_documents[finDeVie][year]' => 2017,
            'gedbundle_documents[file]' => __DIR__.'/../../../../web/test_document/FlorianGrandjean.pdf',
        ));

        // Soumission du formulaire et vérification que l'action appelée est 'DocumentsController::createAction'
        $client->submit($form);

        $this->assertEquals('GedBundle\Controller\DocumentsController::createAction',
            $client->getRequest()->attributes->get('_controller'));

       // Vérification de la redirection suite à la soumission du formulaire
        $client->followRedirect();
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(d.id) from GedBundle:Documents d WHERE d.titre = :titre AND d.auteur = :auteur');
        $query->setParameter('titre', 'Test upload');
        $query->setParameter('auteur', 'Test upload auteur');
        $this->assertTrue(0 < $query->getSingleScalarResult());
      }

    public function testFormAddInvalid()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test avec un file != .pdf
        $form = $crawler->selectButton('Envoyer')->form(array(
            'gedbundle_documents[titre]' => 'Test upload',
            'gedbundle_documents[auteur]' => 'Test upload auteur',
            'gedbundle_documents[resume]' => 'Ceci est un test d\'upload',
            'gedbundle_documents[finDeVie][day]' => 1,
            'gedbundle_documents[finDeVie][month]' => 1,
            'gedbundle_documents[finDeVie][year]' => 2017,
            'gedbundle_documents[file]' => __DIR__.'/../../../../web/test_document/test.gif',
        ));
        $crawler = $client->submit($form);

        // Vérification que l'action appelée est 'DocumentsController::createAction
        $this->assertEquals('GedBundle\Controller\DocumentsController::createAction',
            $client->getRequest()->attributes->get('_controller'));

        // Vérification que le html (suite à erreur de type de fichier) contient le message d'erreur ci dessou
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Le type de fichier n\'est pas supporté.")')->count());

    }

    // CRéation d'un document pour test delete et edit
    public function createDocument($values = array())
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        $form = $crawler->selectButton('Envoyer')->form(array_merge(array(
            'gedbundle_documents[titre]' => 'Test upload',
            'gedbundle_documents[auteur]' => 'Test upload auteur',
            'gedbundle_documents[resume]' => 'Ceci est un test d\'upload',
            'gedbundle_documents[finDeVie][day]' => 1,
            'gedbundle_documents[finDeVie][month]' => 1,
            'gedbundle_documents[finDeVie][year]' => 2017,
            'gedbundle_documents[file]' => __DIR__.'/../../../../web/test_document/FlorianGrandjean.pdf',
        ), $values));

        $client->submit($form);
        $client->followRedirect();

        return $client;
    }

//    public function testDeleteDocuments()
//    {
//        // Connexion en tant qu'admin
//        $client = static::createClient(array(), array(
//            'PHP_AUTH_USER' => 'admin',
//            'PHP_AUTH_PW'   => 'admin',
//        ));
//
//        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
//        $crawler = $client->request('GET', '/documents/nouveau');
//        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
//            $client->getRequest()->attributes->get('_controller'));
//
//        $client = $this->createDocument(array('gedbundle_documents[titre]' => 'FOO2'));
//
//        $crawler = $client->getCrawler();
//        $crawler->selectButton('Supprimer');
//        $crawler->selectButton('oui');
//
//        $this->assertEquals('GedBundle\Controller\DocumentsController::deleteAction',
//            $client->getRequest()->attributes->get('_controller'));
//
//        $kernel = static::createKernel();
//        $kernel->boot();
//        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
//
//        $query = $em->createQuery('SELECT count(d.id) from GedBundle:Documents d WHERE d.titre = :titre');
//        $query->setParameter('titre', 'FOO2');
//        $this->assertTrue(0 == $query->getSingleScalarResult());
//
//        $this->assertContains(
//          'class="alert alert-danger alert-error"',
//          $client->getResponse()->getContent()
//        );
//    }

    public function testEdit()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        // Création d'un doc
        $client = $this->createDocument(array('gedbundle_documents[titre]' => 'FOO2'));

        $crawler->selectButton('Éditer');

        $client->followRedirects();

        $this->assertContains(
            'class="alert alert-danger alert-error"',
            $client->getResponse()->getContent()
        );

        $this->assertEquals('GedBundle\Controller\DocumentsController::editAction',
            $client->getRequest()->attributes->get('_controller'));



    }
}