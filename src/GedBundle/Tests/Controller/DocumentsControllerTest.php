<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentsControllerTest extends WebTestCase
{

    public function testChampsAddDoc() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/documents');

        //$this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /documents");
        $this->assertEquals('UserBundle\Controller\DefaultController::loginAction', $client->getRequest()->attributes->get('_controller'));

        //$this->assertTrue($crawler->filter('html:contains("Titre")')->count() > 1);
        //$this->assertTrue($crawler->filter('form input#gedbundle_document_titre')->count() == 1);

    }


}
