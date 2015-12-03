<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testChampsLogin ()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
        $this->assertTrue($crawler->filter('form input[name="_username"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="_password"]')->count() == 1);
    }

    public function testLoginAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'Admin';
        $form['_password']= 'admin';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));

    }

    public function testLoginUser (){


        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'User';
        $form['_password']= 'user';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));



    }
    public function testLoginBidonUser (){


        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'Nimportequoi';
        $form['_password']= 'rien';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('UserBundle\Controller\SecurityController::loginAction', $client->getRequest()->attributes->get('_controller'));



    }

}
