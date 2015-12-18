<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    // Vérification des champs dans le formulaire de login
    public function testChampsLogin ()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertTrue($crawler->filter('form input[name="_username"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="_password"]')->count() == 1);
    }

    // Test de connexion en temps qu'administrateur, nécessite de loader les fixtures
    public function testLoginAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'admin@admin.com';
        $form['_password']= 'admin';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Test de connexion en temps qu'utilisateur, nécessite de loader les fixtures
    public function testLoginUser ()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username'] = 'user@user.com';
        $form['_password'] = 'user';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Test de connexion en temps qu'utilisateur non inscrit, nécessite de loader les fixtures
    public function testLoginBidonUser ()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'Nimportequoi';
        $form['_password']= 'rien';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/user/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /user/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'userbundle_user[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'userbundle_user[field_name]'  => 'Foo',
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
