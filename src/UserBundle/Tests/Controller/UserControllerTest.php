<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    // Création d'un client User
    public function UserConnection()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user@user.com',
            'PHP_AUTH_PW' => 'user',
        ));
        return $client;
    }

    // Test du lien pour acceder au profile
    public function testLinkProfile()
    {
        $client = $this->UserConnection();

        // Test du lien "accès profil" d'Émilie Perrin
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Émilie")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification des infos qui s'affichent
    public function testShowProfile()
    {
        $client = $this->UserConnection();

        $crawler = $client->request('GET', '/profile/');

        // Verification de l'affichage des infos du profile
        $this->assertEquals(1, $crawler->filter('html:contains("Prenom: Émilie")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Nom: Perrin")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Email: user@user.com")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Organisme")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Fonction: Chargée d\'accueil")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Téléphone: 0368474510")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Modifier mon profil")')->count());

        // Vérification de l'action cibler lors du click sur "Modifier mon profil"
        $link = $crawler->selectLink('Modifier mon profil')->link();
        $crawler = $client->click($link);
        $this->assertEquals('UserBundle\Controller\ProfileController::editAction',
            $client->getRequest()->attributes->get('_controller'));
    }

    // Vérification des champs du formulaire
    public function testChampFormEditProfile()
    {
        $client = $this->UserConnection();

        $crawler = $client->request('GET', '/profile/edit');
        $this->assertEquals('UserBundle\Controller\ProfileController::editAction',
            $client->getRequest()->attributes->get('_controller'));

        // Tests de la présence des champs
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[email]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[current_password]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form select[name="fos_user_profile_form[organisme]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[telephone]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[poste]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[nom]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[prenom]"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="fos_user_profile_form[file]"]')->count() == 1);
    }

    // Test edition du profile
    public function editUser()
    {
        $client = $this->UserConnection();

        $crawler = $client->request('GET', 'admin/documents/nouveau');

        // Soumission du formulaire avec les modifs
        $form = $crawler->selectButton('Envoyer')->form(array_merge(array(
            'fos_user_profile_form[email]' => 'user_test_edit@user.com',
            'fos_user_profile_form[current_password]' => 'user',
            'fos_user_profile_form[organisme]' => 'CAP Emploi',
            'fos_user_profile_form[telephone]' => '0123456789',
            'fos_user_profile_form[poste]' => 'Secretaire',
            'fos_user_profile_form[nom]' => 'name_user_test_edit',
            'fos_user_profile_form[prenom]' => 'username_test_edit',
            'gedbundle_documents[file]' => __DIR__ . '/../../../../web/test_document/test.png'
        )));

        $client->submit($form);

        // Vérification de l'action renvoyé
        $this->assertEquals('UserBundle\Controller\ProfileController::showAction',
            $client->getRequest()->attributes->get('_controller'));

        // Vérification que les infos ont bien été modifié dans l'affichage du profile
        $this->assertEquals(1, $crawler->filter('html:contains("Prenom: username_test_edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Nom: name_user_test_edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Email: user_test_edit@user.com")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Organisme")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Fonction: Secretaire")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Téléphone: 0123456789")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Modifier mon profil")')->count());

        // Verification de l'enregistrement des modifs dans la BDD
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT count(d.id) from UserBundle:User u WHERE u.Prenom = :prenom AND u.Nom = :nom AND u.Email = :email AND u.Fonction = :fonction AND u.Téléphone = :telephone');
        $query->setParameter('prenom', 'username_test_edit');
        $query->setParameter('nom', 'name_user_test_edit');
        $query->setParameter('email', 'user_test_edit@user.com');
        $query->setParameter('fonction', 'Secretaire');
        $query->setParameter('telephone', '0123456789');
        $this->assertTrue(0 < $query->getSingleScalarResult());
    }

}