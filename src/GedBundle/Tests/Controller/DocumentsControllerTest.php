<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use GedBundle\Entity\Documents;
use Symfony\Component\HttpFoundation\Request;

class DocumentsControllerTest extends WebTestCase
{

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'ADMINISTRATEUR //

    // Test des liens de la page documents //
    public function testLink()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien homepage
        $link = $crawler
            ->filter('a:contains("P@rtnet\'emploi du Perche")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "accès profil" d'Antoine Fournier
        $link = $crawler
            ->filter('a:contains("Antoine")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('FOS\UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "déconnexion"
        $link = $crawler
            ->filter('a:contains("déconnexion")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\SecurityController::logoutAction',
            $client->getRequest()->attributes->get('_controller'));

//        // Test du lien d'ajout d'un document
//        $link = $crawler
//            ->filter('a:contains("Ajouter un document")')
//            ->eq(0)
//            ->link();
//        $crawler = $client->click($link);
//        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
//            $client->getRequest()->attributes->get('_controller'));
    }

    // Verification de la présence des champs dans le formulaire
    public function testChampsAddDoc() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
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

    // Fonction permettant de créer un document
    public function createDocument($values = array())
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        $form = $crawler->selectButton('Envoyer')->form(array_merge(array(
            'gedbundle_documents[titre]' => 'createDocument',
            'gedbundle_documents[auteur]' => 'Test upload auteur',
            'gedbundle_documents[resume]' => 'Ceci est un test d\'upload',
            'gedbundle_documents[finDeVie][day]' => 1,
            'gedbundle_documents[finDeVie][month]' => 1,
            'gedbundle_documents[finDeVie][year]' => 2017,
            'gedbundle_documents[file]' => __DIR__.'/../../../../web/test_document/FlorianGrandjean.pdf',
        ), $values));

        $client->submit($form);

        $this->assertEquals('GedBundle\Controller\DocumentsController::createAction',
            $client->getRequest()->attributes->get('_controller'));

        return $client;
    }

    // Test du formulaire d'upload
    public function testFormAddValid()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Définition du formulaire
        $client = $this->createDocument(array('gedbundle_documents[titre]' => 'testFormAddValid'));

        $client->followRedirect();

       // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(d.id) from GedBundle:Documents d WHERE d.titre = :titre AND d.auteur = :auteur');
        $query->setParameter('titre', 'testFormAddValid');
        $query->setParameter('auteur', 'Test upload auteur');
        $this->assertTrue(0 < $query->getSingleScalarResult());

      }

    public function testFormAddInvalid()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/nouveau');
        $this->assertEquals('GedBundle\Controller\DocumentsController::newAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test avec un file != .pdf
        $form = $crawler->selectButton('Envoyer')->form(array(
            'gedbundle_documents[titre]' => 'testFormAddInvalid',
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

    public function testEdit()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Création d'un doc
        $client = $this->createDocument(array('gedbundle_documents[titre]' => 'testEdit'));

        $client->followRedirect();

        $crawler = $client->getCrawler();

        $link = $crawler
            ->filter('td:contains("testEdit")')
            ->siblings()
            ->eq(4)
            ->children()
            ->eq(0)
            ->link()
        ;

        $crawler = $client->click($link);

        $client->followRedirects();

        $this->assertEquals('GedBundle\Controller\DocumentsController::editAction',
            $client->getRequest()->attributes->get('_controller'));

        $form = $crawler->selectButton('Update')->form(array(
            'gedbundle_documents[titre]' => 'edit_test_titre',
            'gedbundle_documents[auteur]' => 'edit_test_auteur',
        ));

        // Soumission du formulaire et vérification que l'action appelée est 'DocumentsController::indexAction'
        $client->submit($form);

        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(d.id) from GedBundle:Documents d WHERE d.titre = :titre AND d.auteur = :auteur');
        $query->setParameter('titre', 'edit_test_titre');
        $query->setParameter('auteur', 'edit_test_auteur');
        $this->assertTrue(0 < $query->getSingleScalarResult());
    }

    public function testDeleteDocuments()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->getCrawler();

        $link1 = $crawler
            ->filter('td:contains("testFormAddValid")')
            ->siblings()
            ->eq(4)
            ->children()
            ->eq(1)
            ->link()
        ;

        $link2 = $crawler
            ->filter('td:contains("edit_test_titre")')
            ->siblings()
            ->eq(4)
            ->children()
            ->eq(1)
            ->link()
        ;

        $crawler = $client->click($link1);
        $crawler->selectButton('oui');

        $this->assertEquals('GedBundle\Controller\DocumentsController::deleteAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->click($link2);
        $crawler->selectButton('oui');

        $this->assertEquals('GedBundle\Controller\DocumentsController::deleteAction',
            $client->getRequest()->attributes->get('_controller'));

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(d.id) from GedBundle:Documents d WHERE d.titre = :titre AND d.titre = :titre2');
        $query->setParameter('titre', 'edit_test_titre');
        $query->setParameter('titre2', 'testFormAddValid');
        $this->assertTrue(0 == $query->getSingleScalarResult());
    }

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'UTILISATEUR //

    // Verification que certain champs ne sont pas présent pour l'utilisateur
    public function testChampUser()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user@user.com',
            'PHP_AUTH_PW'   => 'user',
        ));

        $crawler = $client->request('GET', '/documents/');

        // Tests de la présence des champs
        $this->assertEquals(0, $crawler->filter('html:contains("Ajouter un document")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("Éditer")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("Supprimer")')->count());
    }
}

//        $this->assertContains(
//            'class="alert alert-danger alert-error"',
//            $client->getResponse()->getContent()
//        );