<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
        $this->assertTrue($crawler->filter('form input[name="_username"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="_password"]')->count() == 1);


        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'bidule';
        $form['_password']= 'mamad';

        $crawler = $client->submit($form);

        // Il faut suivre la redirection
        $crawler = $client->followRedirect();
        $this->assertEquals('FOS\UserBundle\Controller\SecurityController::loginAction', $client->getRequest()->attributes->get('_controller'));


        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username']= 'mamad';
        $form['_password']= 'mamad';

        $crawler = $client->submit($form);

        $this->assertEquals('FOS\UserBundle\Controller\SecurityController::checkAction', $client->getRequest()->attributes->get('_controller'));
        //$this->assertTrue(301 === $client->getResponse()->getStatusCode());
    }
}
