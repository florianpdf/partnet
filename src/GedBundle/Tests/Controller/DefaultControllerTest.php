<?php

namespace GedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/documents');

        $this->assertTrue($crawler->filter('html:contains("Titre")')->count() > 0);
        $this->assertTrue($crawler->filter('form input#document_titre')->count() == 1);
    }
}
