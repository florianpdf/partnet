<?php
// src/GedBundle/DataFixtures/ORM/LoadOffresData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace OffresBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use OffresBundle\Entity\Offres;

class LoadGedData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // First, delete all files in app/uploads/offres
        array_map('unlink', glob("app/uploads/offres/*.pdf"));

        $offre = new Documents();
        $offre->setTitre('Standardiste');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('CIDJ');
        $offre->setLieu('CIDJ');
        $offre->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum lorem auctor, vestibulum leo a, sollicitudin erat. Maecenas eget varius ante. Cras pretium ullamcorper tellus nec efficitur. Curabitur congue urna eget tortor rhoncus sodales. Nulla facilisi. Donec fermentum dui ut posuere egestas. Integer blandit, lectus et laoreet vehicula, dui lectus hendrerit turpis, et mattis sem nibh non dui. Donec nec ligula nec odio ornare ultricies ac quis lectus.');
        $offre->createFile("pdf");
        $offre->setFileName('test_upload.pdf');
        $offre->setDateAjout(new \DateTime('08/15/2015'));
        $offre->setFilActu('0');
        $manager->persist($document);

        $offre = new Documents();
        $offre->setTitre('Les concours de la fonction publique');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('CNED');
        $offre->setLieu('CIDJ');
        $offre->setResume('Nunc vitae dui vel sem vehicula venenatis a pellentesque tortor. Integer eget mollis erat. Suspendisse est arcu, facilisis in nisi non, ultricies ultrices dui. Pellentesque felis tellus, luctus id tellus sit amet, condimentum faucibus massa. Aenean rhoncus commodo sapien vestibulum tristique. Sed tristique lacus elit, et tristique sem placerat eu. Pellentesque sed leo dui.');
        $offre->createFile("pdf");
        $offre->setFileName('test_upload.pdf');
        $offre->setDateAjout(new \DateTime('08/30/2015'));
        $offre->setFilActu('1');
        $manager->persist($document);

        $offre = new Documents();
        $offre->setTitre('Convaincre en moins de 2 minutes');
        $offre->setUser($this->getReference('uploader-superadmin'));
        $offre->setEntreprise('Nicholas Boothman');
        $offre->setLieu('CIDJ');
        $offre->setResume('Ce livre vous offrira, grâce à la maîtrise des bases de la PNL, toutes les clés pour : adapter votre mode de communication à la personnalité de votre interlocuteur afin d\'établir crédibilité et autorité ; savoir transmettre clairement en 10 secondes chrono l\'idée directrice de votre exposé et capter l\'attention de votre auditoire ; maximiser chaque opportunité professionnelle.');
        $offre->createFile("pdf");
        $offre->setFileName('test_upload.pdf');
        $offre->setDateAjout(new \DateTime('07/10/2015'));
        $offre->setFilActu('1');
        $manager->persist($document);

        $offre = new Documents();
        $offre->setTitre('Évolution de l\'emploi en Centre-Val de Loire');
        $offre->setUser($this->getReference('uploader-superadmin'));
        $offre->setEntreprise('INSEE');
        $offre->setLieu('CIDJ');
        $offre->setResume('Vivamus eros felis, tincidunt nec justo vel, imperdiet varius ligula. Nulla finibus ante enim. Donec a ex euismod, accumsan nulla eget, sagittis enim. Duis vitae rhoncus arcu. Pellentesque ac neque a risus volutpat pellentesque. Etiam vulputate faucibus dictum. Proin dignissim mi porttitor libero interdum, vel sagittis ipsum convallis.');
        $offre->createFile("pdf");
        $offre->setFileName('test_upload.pdf');
        $offre->setDateAjout(new \DateTime('09/01/2015'));
        $offre->setFilActu('0');
        $manager->persist($document);

        $offre = new Documents();
        $offre->setTitre('Que faire sans le bac ?');
        $offre->setUser($this->getReference('uploader-admin'));
        $offre->setEntreprise('CNED');
        $offre->setLieu('CIDJ');
        $offre->setResume('Phasellus bibendum bibendum molestie. Sed at leo eleifend diam pellentesque malesuada sed eu eros. Donec elementum mi sed tortor pellentesque laoreet vel id urna. Aliquam mollis mauris ac augue blandit blandit. Nunc accumsan egestas risus mattis commodo. Sed sapien libero, vehicula sit amet arcu eu, eleifend fermentum ipsum. Nullam sit amet nulla euismod, vestibulum arcu ut, elementum est. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec neque odio, tincidunt sed mattis sed, cursus at tellus. Vivamus condimentum lectus nulla, et sagittis eros mollis vitae. Nulla facilisi.');
        $offre->createFile("pdf");
        $offre->setFileName('test_upload.pdf');
        $offre->setDateAjout(new \DateTime('09/07/2015'));
        $offre->setFilActu('0');
        $manager->persist($document);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
