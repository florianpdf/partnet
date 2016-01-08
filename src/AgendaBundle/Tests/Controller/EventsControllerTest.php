<?php

namespace AgendaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventsControllerTest extends WebTestCase
{

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'ADMINISTRATEUR //

    // Connexion en tant qu'admin //
    public function AdminConnection()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW' => 'admin',
        ));
        return $client;
    }

    public function testLinkAdmin()
    {
        $client = $this->AdminConnection();

        // On va sur la page document
        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
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
        $crawler = $client->request('GET', '/agenda/');
        $link = $crawler
            ->filter('a:contains("Antoine")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de la présence des id des différentes div sur page agenda
        $crawler = $client->request('GET', '/agenda/');
        $this->assertTrue($crawler->filter('body#agenda')->count() == 1);
        $this->assertTrue($crawler->filter('div#calendar')->count() == 1);
        $this->assertTrue($crawler->filter('div#fullCalModal')->count() == 1);
        $this->assertTrue($crawler->filter('div#top-bar')->count() == 1);
        $this->assertTrue($crawler->filter('div#menu-wrapper')->count() == 1);

        // Test du lien "déconnexion"
        $crawler = $client->request('GET', '/agenda/');
        $link = $crawler
            ->filter('a:contains("déconnexion")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\SecurityController::logoutAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification que l'action de '/documents' est bien 'DocumentsController::indexAction'
    public function testGetDocument()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification que l'action de '/documents/nouveau' est bien 'DocumentsController::newAction'
    public function testGetDocumentNouveau()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');
        $this->assertEquals('AgendaBundle\Controller\EventsController::newAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Verification de la présence des champs dans le formulaire
    public function testChampsAddDoc() {

        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');

        // Tests de la présence des champs
        $this->assertTrue($crawler->filter('div#agendabundle_events_start')->count() == 1);
        $this->assertTrue($crawler->filter('div#date_start_event')->count() == 1);
        $this->assertTrue($crawler->filter('html:contains(Vendredi janvier)')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][day]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][month]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][year]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][time][hour]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][time][minute]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="agendabundle_events[titre]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form textarea[name="agendabundle_events[contenu]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form button[name="agendabundle_events[submit]"]')->count() == 1);
        $this->assertTrue($crawler->filter('a:contains(Retourner au calendrier)')->count() == 1);
    }

    // On vérifie la redirection du lien "Retourner au calendrier"
    public function testLinkNewEvent() {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');
        $link = $crawler->filter('a:contains("Retourner au calendrier")')->link();
        $crawler = $client->click($link);
        $client->followRedirects();
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Fonction permettant de créer un evènement
    public function createEvent($values = array())
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');

        $form = $crawler->selectButton('Créer l\'évènement')->form(array_merge(array(
            'agendabundle_events[end][date][day]' => 01,
            'agendabundle_events[end][date][month]' => 01,
            'agendabundle_events[end][date][year]' => 2016,
            'agendabundle_events[end][time][hour]' => 10,
            'agendabundle_events[end][time][minute]' => 30,
            'agendabundle_events[titre]' => 'Test création event',
            'agendabundle_events[contenu]' => 'Ceci est un test de création d\'évent',
        ), $values));

        $client->submit($form);

        $this->assertEquals('AgendaBundle\Controller\EventsController::createAction',
            $client->getRequest()->attributes->get('_controller'));

        return $client;
    }

    // Test du formulaire de création d'evenement
    public function testFormAddValid()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');

        // Création du document
        $client = $this->createEvent(array(
            'agendabundle_events[titre]' => 'Test evenement valide + de 1H',
            'agendabundle_events[contenu]' => 'Test evenement de plus d\'une heure'));

        $client->followRedirect();

        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // A approfondir, test sur contenu generer par du js
        // Vérification que l'evenemtn est bien dans le calendrier
        //$crawler = $client->request('GET', '/agenda/');
        //$this->assertGreaterThan(0, $crawler->filter('html:contains("Test evenement valide + de 1H")')->count());

        // Test de l'enregistrement dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) from AgendaBundle:Events e WHERE e.titre = :titre AND e.contenu = :contenu');
        $query->setParameter('titre', 'Test evenement valide + de 1H');
        $query->setParameter('contenu', 'Test evenement de plus d\'une heure');
        $this->assertTrue(1 == $query->getSingleScalarResult());
    }

    public function testFormAddInValid()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'admin/event/%202016-01-01T09:00:00/new');

        // Création du document
        $client = $this->createEvent(array(
            'agendabundle_events[end][time][hour]' => 9,
            'agendabundle_events[end][time][minute]' => 30,
            'agendabundle_events[titre]' => 'Test evenement invalide - de 1H',
            'agendabundle_events[contenu]' => 'Test evenement de 30min'));

        $client->followRedirect();

        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // A approfondir, test sur contenu generer par du js
        // Vérification que l'evenemtn est bien dans le calendrier
        //$crawler = $client->request('GET', '/agenda/');
        //$this->assertGreaterThan(0, $crawler->filter('html:contains("Test evenement valide + de 1H")')->count());

        // Test de l'enregistrement dans la BDD que l'évènement enregistré dure une heure
        // Ici la date de début d'event est à 9h, donc date de fin == 10h
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) from AgendaBundle:Events e WHERE e.titre = :titre AND e.contenu = :contenu AND e.end = :dateEnd');
        $query->setParameter('titre', 'Test evenement invalide - de 1H');
        $query->setParameter('contenu', 'Test evenement de 30min');
        $query->setParameter('dateEnd', '2016-01-01 10:00:00');
        $this->assertTrue(1 == $query->getSingleScalarResult());
    }
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/events/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /events/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'agendabundle_events[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'agendabundle_events[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
