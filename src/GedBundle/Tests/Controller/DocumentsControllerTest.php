<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentsControllerTest extends WebTestCase
{

    public function testChampsAddDoc() {

        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Sélection basée sur la valeur, l'id ou le nom des boutons
        $form = $crawler->selectButton('Connexion')->form();
        $form['_username']= 'Admin';
        $form['_password']= 'admin';
        $crawler = $client->submit($form);

        $crawler = $client->request('GET', '/documents');

        $crawler = $client->followRedirect('AppBundle\Controller\DefaultController::indexAction');
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[titre]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[auteur]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form textarea[name="gedbundle_documents[resume]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][day]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][month]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="gedbundle_documents[finDeVie][year]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="gedbundle_documents[file]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form button[name="gedbundle_documents[submit]"]')->count() == 1);

    }


}
