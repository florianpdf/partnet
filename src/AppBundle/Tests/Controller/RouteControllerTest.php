<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteControllerTest extends WebTestCase
{
    public function UserConnection()
    {
        // Connexion en tant qu'user
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user@user.com',
            'PHP_AUTH_PW' => 'user',
        ));
        return $client;
    }

    public function AdminConnection()
    {
        // Connexion en tant qu'admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW' => 'admin',
        ));
        return $client;
    }

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'ANONYME //

    public function testRouteAnonyme()
    {
        $client = static::createClient();

        // Test page d'accueil
        $crawler = $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/annuaire/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/message/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/profile/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/admin/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));

//        $this->assertContains(
//            'class="alert alert-danger alert-error"',
//            $client->getResponse()->getContent()
//        );
    }

    // On test l'accès au route en tant que User
    public function testRouteUser()
    {
        $client = $this->UserConnection();

        $crawler = $client->request('GET', '/');
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/annuaire/');
        $this->assertEquals('AnnuaireBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/message/');
        $this->assertEquals('MsgBundle\Controller\MessageController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/profile/');
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/admin/');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

//        $this->assertContains(
//            'class="alert alert-danger alert-error"',
//            $client->getResponse()->getContent()
//        );
    }

    // On test l'accès au route en tant que User
    public function testRouteAdmin()
    {
        $client = $this->AdminConnection();

        $client->request('GET', '/');
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/annuaire/');
        $this->assertEquals('AnnuaireBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/message/');
        $this->assertEquals('MsgBundle\Controller\MessageController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/agenda/');
        $this->assertEquals('AgendaBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/profile/');
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        $crawler = $client->request('GET', '/admin/');
        $this->assertEquals('AppBundle\Controller\DefaultController::adminAction',
            $client->getRequest()->attributes->get('_controller'));

//        $this->assertContains(
//            'class="alert alert-danger alert-error"',
//            $client->getResponse()->getContent()
//        );
    }
}