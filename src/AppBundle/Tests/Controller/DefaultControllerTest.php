<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'ANONYME //

    public function testLinkAnonyme()
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

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'Utilisateur //

    // Test des liens de la page documents //
    public function UserConnection()
    {
        // Connexion en tant qu'user
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user@user.com',
            'PHP_AUTH_PW' => 'user',
        ));
        return $client;
    }

    public function testLinkUser()
    {
        $client = $this->UserConnection();

        // Test page d'accueil
        $crawler = $client->request('GET', '/');
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test page document
        $link = $crawler
            ->filter('a:contains("Documents")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien homepage
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("P@rtnet\'emploi du Perche")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "accès profil" d'Émilie Perrin
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Émilie")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien Annuaire
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Annuaire")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AnnuaireBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien Dialogue
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Dialogue")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('MsgBundle\Controller\MessageController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "déconnexion"
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("déconnexion")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\SecurityController::logoutAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // TOUS LES TESTS CI DESSOUS SONT EXECUTES EN TANT QU'ADMINISTRATEUR //

    // Test des liens de la page documents //
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

        // Test page d'accueil
        $crawler = $client->request('GET', '/');
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test page document
        $link = $crawler
            ->filter('a:contains("Documents")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien homepage
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("P@rtnet\'emploi du Perche")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "accès profil" d'Antoine Fournier
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Antoine")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien Annuaire
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Annuaire")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AnnuaireBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien Dialogue
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Dialogue")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('MsgBundle\Controller\MessageController::indexAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien Interface d'administration
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Interface d\'administration")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('AppBundle\Controller\DefaultController::adminAction',
            $client->getRequest()->attributes->get('_controller'));

        // Test du lien "déconnexion"
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("déconnexion")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\SecurityController::logoutAction',
            $client->getRequest()->attributes->get('_controller'));
    }
}
