<?php
// src/GedBundle/DataFixtures/ORM/LoadOffresData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace OffresBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use OffresBundle\Entity\Offres;

class LoadOffresData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // First, delete all files in app/uploads/offres
        array_map('unlink', glob("app/uploads/offres/*.pdf"));

        $offre = new Offres();
        $offre->setTitre('Standardiste');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('Thales');
        $offre->setLieu('Colombes');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $offre->createFile("pdf");
        $offre->setFileName('offre_1.pdf');
        $offre->setDateAjout(new \DateTime('01/05/2016'));
        $offre->setFilActu('0');
        $manager->persist($offre);

        $offre = new Offres();
        $offre->setTitre('Développeur front-end');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('Mentalworks');
        $offre->setLieu('Compiègne');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $offre->createFile("pdf");
        $offre->setFileName('offre_4.pdf');
        $offre->setDateAjout(new \DateTime('01/19/2016'));
        $offre->setFilActu('1');
        $manager->persist($offre);

        $offre = new Offres();
        $offre->setTitre('Responsable commercial');
        $offre->setUser($this->getReference('uploader-superadmin'));
        $offre->setEntreprise('Bouygues Telecom');
        $offre->setLieu('Paris');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $offre->createFile("pdf");
        $offre->setFileName('offre_5.pdf');
        $offre->setDateAjout(new \DateTime('01/24/2016'));
        $offre->setFilActu('1');
        $manager->persist($offre);

        $offre = new Offres();
        $offre->setTitre('Assistant ressources humaines');
        $offre->setUser($this->getReference('uploader-superadmin'));
        $offre->setEntreprise('DGFIP');
        $offre->setLieu('Lille');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $offre->createFile("pdf");
        $offre->setFileName('offre_3.pdf');
        $offre->setDateAjout(new \DateTime('01/13/2016'));
        $offre->setFilActu('0');
        $manager->persist($offre);

        $offre = new Offres();
        $offre->setTitre('Records manager');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('Manpower');
        $offre->setLieu('Bordeaux');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $offre->createFile("pdf");
        $offre->setFileName('offre_2.pdf');
        $offre->setDateAjout(new \DateTime('01/10/2016'));
        $offre->setFilActu('0');
        $manager->persist($offre);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
