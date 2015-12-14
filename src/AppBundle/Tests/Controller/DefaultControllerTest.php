<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', '/documents/');
        $this->assertEquals('GedBundle\Controller\DocumentsController::indexAction',
            $client->getRequest()->attributes->get('_controller'));
    }
}
