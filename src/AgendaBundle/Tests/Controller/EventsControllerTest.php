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
            ->filter('a:contains("P@rtnet")')
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
//        $crawler = $client->request('GET', '/agenda/');
//        $link = $crawler
//            ->filter('a.title("déconnexion")')
//            ->eq(0)
//            ->link();
//        $crawler = $client->click($link);
//        $this->assertEquals('UserBundle\Controller\SecurityController::logoutAction',
//            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification que l'action de '/agenda' est bien 'DefaultController::indexAction'
    public function testAgenda()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification que l'action de 'event{id}/new' est bien 'EventsController::newAction'
    public function testEventNew()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'agenda/events/%202020-01-01T09:00:00/new');
        $this->assertEquals('AgendaBundle\Controller\EventsController::newAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Verification de la présence des champs dans le formulaire
    public function testChampsAddDoc() {

        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'agenda/events/%202020-01-01T09:00:00/new');

        // Tests de la présence des champs
        $this->assertTrue($crawler->filter('div#agendabundle_events_start')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][day]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][month]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][date][year]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][time][hour]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="agendabundle_events[end][time][minute]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="agendabundle_events[titre]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form textarea[name="agendabundle_events[resume]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form button[name="agendabundle_events[submit]"]')->count() == 1);
        $this->assertEquals(1, $crawler->filter('html:contains("Ajouter au fil d\'actualité")')->count());
    }

    // Fonction permettant de créer un evènement
    public function createEvent($values = array())
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'agenda/events/%202020-01-01T09:00:00/new');

        $form = $crawler->selectButton('Créer l\'évènement')->form(array_merge(array(
            'agendabundle_events[end][date][day]' => 01,
            'agendabundle_events[end][date][month]' => 01,
            'agendabundle_events[end][date][year]' => 2020,
            'agendabundle_events[end][time][hour]' => 10,
            'agendabundle_events[end][time][minute]' => 30,
            'agendabundle_events[titre]' => 'Test création event',
            'agendabundle_events[resume]' => 'Ceci est un test de création d\'évent',
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

        $crawler = $client->request('GET', 'agenda/events/%202020-01-01T09:00:00/new');

        // Création du document
        $client = $this->createEvent(array(
            'agendabundle_events[titre]' => 'Test evenement valide + de 1H',
            'agendabundle_events[resume]' => 'Test evenement de plus d\'une heure'));

        $client->followRedirect();

        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) from AgendaBundle:Events e WHERE e.titre = :titre AND e.resume = :resume');
        $query->setParameter('titre', 'Test evenement valide + de 1H');
        $query->setParameter('resume', 'Test evenement de plus d\'une heure');
        $this->assertTrue(1 == $query->getSingleScalarResult());
    }

    public function testFormAddInValid()
    {
        $client = $this->AdminConnection();

        $crawler = $client->request('GET', 'agenda/events/%202020-01-01T09:00:00/new');

        // Création du document
        $client = $this->createEvent(array(
            'agendabundle_events[end][time][hour]' => 9,
            'agendabundle_events[end][time][minute]' => 30,
            'agendabundle_events[titre]' => 'Test evenement invalide - de 1H',
            'agendabundle_events[resume]' => 'Test evenement de 30min'));

        $client->followRedirect();

        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD que l'évènement enregistré dure une heure
        // Ici la date de début d'event est à 9h, donc date de fin == 10h
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) FROM AgendaBundle:Events e WHERE e.titre = :titre AND e.resume = :resume AND e.end = :dateEnd');
        $query->setParameter('titre', 'Test evenement invalide - de 1H');
        $query->setParameter('resume', 'Test evenement de 30min');
        $query->setParameter('dateEnd', '2020-01-01 10:00:00');
        $this->assertTrue(1 == $query->getSingleScalarResult());
    }

    public function testFormEdit()
    {
        $client = $this->AdminConnection();

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $id = $em->getRepository('AgendaBundle:Events')->findOneByTitre('Test evenement invalide - de 1H')->getId();

        $crawler = $client->request('GET', 'event/' . $id . '/edit');

        // Création du document
        $client = $this->createEvent(array(
            'agendabundle_events[end][time][hour]' => 11,
            'agendabundle_events[end][time][minute]' => 30,
            'agendabundle_events[titre]' => 'Test edit evenement',
            'agendabundle_events[resume]' => 'Test edit evenement'));

        $client->followRedirect();

        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test de l'enregistrement dans la BDD que l'évènement enregistré dure une heure
        // Ici la date de début d'event est à 9h, donc date de fin == 10h
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) from AgendaBundle:Events e WHERE e.titre = :titre AND e.resume = :resume AND e.end = :dateEnd');
        $query->setParameter('titre', 'Test edit evenement');
        $query->setParameter('resume', 'Test edit evenement');
        $query->setParameter('dateEnd', '2020-01-01 11:30:00');
        $this->assertTrue(1 == $query->getSingleScalarResult());
    }

    public function DeleteEvent()
    {
        $client = $this->AdminConnection();

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $id = $em->getRepository('AgendaBundle:Events')->findBy(array('Titre' => array('Test edit evenement', 'Test evenement valide + de 1H')))->getId();

        // Suppression du 1er event
        $client->request('GET', 'event/' . $id[0] . '/delete');
        $client->followRedirect();
        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Suppression du 2ème event
        $client->request('GET', 'event/' . $id[1] . '/delete');
        $client->followRedirect();
        // Vérification de la redirection suite à la soumission du formulaire
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // On vérifie que les deux event ont été supprimé
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(e.id) from AgendaBundle:Events e WHERE e.titre = :titre AND e.titre = :titre2');
        $query->setParameter('titre', 'Test edit evenement');
        $query->setParameter('titre2', 'Test evenement valide + de 1H');
        $this->assertTrue(0 == $query->getSingleScalarResult());
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
