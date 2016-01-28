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

        $poleemploi = new Organisme();

        copy($poleemploi->getFixturesPath() . 'pole_emploi.png', 'app/uploads/organismes_pictures/pole_emploi.png');

        $poleemploi->setPhoto('pole_emploi.png');
        $poleemploi->setNom('Pôle emploi');
        $poleemploi->setDescription('Pôle emploi est un établissement public à caractère administratif (EPA), chargé de l\'emploi en France. Créé le 19 décembre 2008, il est issu de la fusion entre l\'ANPE et les Assédic.');
        $poleemploi->setBackgroundColor('#40A497');
        $manager->persist($poleemploi);

        $dirrecte = new Organisme();

        copy($dirrecte->getFixturesPath() . 'direccte.png', 'app/uploads/organismes_pictures/direccte.png');

        $dirrecte->setPhoto('direccte.png');
        $dirrecte->setNom('DIRECCTE');
        $dirrecte->setBackgroundColor('#4C3441');
        $dirrecte->setDescription('Les directions régionales des entreprises, de la concurrence, de la consommation, du travail et de l\'emploi (DIRECCTE ou DIECCTE dans les régions et départements d’outre-mer) sont des services déconcentrés de l\'Etat sous tutelle commune du Ministère du Travail, de l\'Emploi, de la Formation Professionnelle et du Dialogue Social et du ministère de l’Économie, des Finances et de l’Industrie.');
        $manager->persist($dirrecte);

        $ml = new Organisme();

        copy($ml->getFixturesPath() . 'mission_locale.png', 'app/uploads/organismes_pictures/mission_locale.png');

        $ml->setPhoto('mission_locale.png');
        $ml->setNom('Mission Locale');
        $ml->setBackgroundColor('#1AB26B');
        $ml->setDescription('Les missions locales pour l\'insertion professionnelle et sociale des jeunes (couramment appelées missions locales) sont, en France, des organismes chargés d’aider les jeunes à résoudre l’ensemble des problèmes que pose leur insertion professionnelle et sociale.');
        $manager->persist($ml);

        $capemploi = new Organisme();

        copy($capemploi->getFixturesPath() . 'cap_emploi.png', 'app/uploads/organismes_pictures/cap_emploi.png');

        $capemploi->setPhoto('cap_emploi.png');
        $capemploi->setNom('CAP Emploi');
        $capemploi->setBackgroundColor('#B29E1A');
        $capemploi->setDescription('Cap emploi est un réseau d\'accompagnement des bénéficiaires de la loi de février 2005, dans leur parcours d\'insertion professionnelle (élaboration de projet, accès à la formation, accès à l\'emploi), en milieu ordinaire de travail. Il intervient également auprès des employeurs, privés ou publics, pour faciliter le recrutement, l\'intégration et le maintien en emploi des travailleurs handicapés.');
        $manager->persist($capemploi);

        $sousprefecture = new Organisme();

        copy($sousprefecture->getFixturesPath() . 'sous-prefecture.png', 'app/uploads/organismes_pictures/sous-prefecture.png');

        $sousprefecture->setPhoto('sous-prefecture.png');
        $sousprefecture->setNom('Sous-préfecture');
        $sousprefecture->setBackgroundColor('#B21A7A');
        $sousprefecture->setDescription('Bureaux de l\'administration préfectorale');
        $manager->persist($sousprefecture);

        $manager->flush();

        $this->addReference('1', $poleemploi);
        $this->addReference('2', $dirrecte);
        $this->addReference('3', $ml);
        $this->addReference('4', $capemploi);
        $this->addReference('5', $sousprefecture);
    }

    public function getOrder()
    {
        return 1;
    }
}
