<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Organisme;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class LoadAppData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // First, delete all files in app/uploads/documents
        array_map('unlink', glob("app/uploads/organismes_pictures/*.*"));

        $organisme = new Organisme();

        copy($organisme->getFixturesPath() . 'poleemploi.jpg', 'app/uploads/organismes_pictures/poleemploi.jpg');

        $organisme->setPhoto('poleemploi.jpg');
        $organisme->setNom('Pôle emploi');
        $organisme->setDescription('Pôle emploi est un établissement public à caractère administratif (EPA), chargé de l\'emploi en France. Créé le 19 décembre 2008, il est issu de la fusion entre l\'ANPE et les Assédic.');
        $manager->persist($organisme);

        $organisme = new Organisme();

        copy($organisme->getFixturesPath() . 'dirrecte.jpg', 'app/uploads/organismes_pictures/dirrecte.jpg');

        $organisme->setPhoto('dirrecte.jpg');
        $organisme->setNom('DIRRECTE');
        $organisme->setDescription('Les directions régionales des entreprises, de la concurrence, de la consommation, du travail et de l\'emploi (DIRECCTE ou DIECCTE dans les régions et départements d’outre-mer) sont des services déconcentrés de l\'Etat sous tutelle commune du Ministère du Travail, de l\'Emploi, de la Formation Professionnelle et du Dialogue Social et du ministère de l’Économie, des Finances et de l’Industrie.');
        $manager->persist($organisme);

        $organisme = new Organisme();

        copy($organisme->getFixturesPath() . 'ml.jpg', 'app/uploads/organismes_pictures/ml.jpg');

        $organisme->setPhoto('ml.jpg');
        $organisme->setNom('Mission Locale');
        $organisme->setDescription('Les missions locales pour l\'insertion professionnelle et sociale des jeunes (couramment appelées missions locales) sont, en France, des organismes chargés d’aider les jeunes à résoudre l’ensemble des problèmes que pose leur insertion professionnelle et sociale.');
        $manager->persist($organisme);

        $organisme = new Organisme();

        copy($organisme->getFixturesPath() . 'capemploi.jpg', 'app/uploads/organismes_pictures/capemploi.jpg');

        $organisme->setPhoto('capemploi.jpg');
        $organisme->setNom('CAP Emploi');
        $organisme->setDescription('Cap emploi est un réseau d\'accompagnement des bénéficiaires de la loi de février 2005, dans leur parcours d\'insertion professionnelle (élaboration de projet, accès à la formation, accès à l\'emploi), en milieu ordinaire de travail. Il intervient également auprès des employeurs, privés ou publics, pour faciliter le recrutement, l\'intégration et le maintien en emploi des travailleurs handicapés.');
        $manager->persist($organisme);

        $organisme = new Organisme();

        copy($organisme->getFixturesPath() . 'sousprefecture.jpg', 'app/uploads/organismes_pictures/sousprefecture.jpg');

        $organisme->setPhoto('sousprefecture.jpg');
        $organisme->setNom('Sous préfecture');
        $organisme->setDescription('Bureaux de l\'administration préfectorale');
        $manager->persist($organisme);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
