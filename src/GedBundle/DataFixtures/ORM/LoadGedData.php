<?php
// src/GedBundle/DataFixtures/ORM/LoadGedData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace GedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use GedBundle\Entity\Documents;

class LoadGedData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // First, delete all files in app/uploads/documents
        array_map('unlink', glob("app/uploads/documents/*.pdf"));

        $document = new Documents();
        $document->setTitre('Réussir ses premiers pas en entreprise');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('CIDJ');
        $document->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum lorem auctor, vestibulum leo a, sollicitudin erat. Maecenas eget varius ante. Cras pretium ullamcorper tellus nec efficitur. Curabitur congue urna eget tortor rhoncus sodales. Nulla facilisi. Donec fermentum dui ut posuere egestas. Integer blandit, lectus et laoreet vehicula, dui lectus hendrerit turpis, et mattis sem nibh non dui. Donec nec ligula nec odio ornare ultricies ac quis lectus.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/15/2015'));
        $document->setFinDeVie(new \DateTime('01/01/2016'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Les concours de la fonction publique');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('CNED');
        $document->setResume('Nunc vitae dui vel sem vehicula venenatis a pellentesque tortor. Integer eget mollis erat. Suspendisse est arcu, facilisis in nisi non, ultricies ultrices dui. Pellentesque felis tellus, luctus id tellus sit amet, condimentum faucibus massa. Aenean rhoncus commodo sapien vestibulum tristique. Sed tristique lacus elit, et tristique sem placerat eu. Pellentesque sed leo dui.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/30/2015'));
        $document->setFinDeVie(new \DateTime('06/01/2016'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Convaincre en moins de 2 minutes');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('Nicholas Boothman');
        $document->setResume('Ce livre vous offrira, grâce à la maîtrise des bases de la PNL, toutes les clés pour : adapter votre mode de communication à la personnalité de votre interlocuteur afin d\'établir crédibilité et autorité ; savoir transmettre clairement en 10 secondes chrono l\'idée directrice de votre exposé et capter l\'attention de votre auditoire ; maximiser chaque opportunité professionnelle.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('07/10/2015'));
        $document->setFinDeVie(new \DateTime('01/01/2017'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Évolution de l\'emploi en Centre-Val de Loire');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('INSEE');
        $document->setResume('Vivamus eros felis, tincidunt nec justo vel, imperdiet varius ligula. Nulla finibus ante enim. Donec a ex euismod, accumsan nulla eget, sagittis enim. Duis vitae rhoncus arcu. Pellentesque ac neque a risus volutpat pellentesque. Etiam vulputate faucibus dictum. Proin dignissim mi porttitor libero interdum, vel sagittis ipsum convallis.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('09/01/2015'));
        $document->setFinDeVie(new \DateTime('02/01/2016'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Que faire sans le bac ?');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('CNED');
        $document->setResume('Phasellus bibendum bibendum molestie. Sed at leo eleifend diam pellentesque malesuada sed eu eros. Donec elementum mi sed tortor pellentesque laoreet vel id urna. Aliquam mollis mauris ac augue blandit blandit. Nunc accumsan egestas risus mattis commodo. Sed sapien libero, vehicula sit amet arcu eu, eleifend fermentum ipsum. Nullam sit amet nulla euismod, vestibulum arcu ut, elementum est. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec neque odio, tincidunt sed mattis sed, cursus at tellus. Vivamus condimentum lectus nulla, et sagittis eros mollis vitae. Nulla facilisi.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('09/07/2015'));
        $document->setFinDeVie(new \DateTime('06/01/2018'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('La transformation numérique de l\'économie');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('INPI');
        $document->setResume('Mauris quis ligula enim. Curabitur pulvinar, metus vel tempor vestibulum, tellus purus finibus ligula, commodo suscipit ante neque sed lorem. Nulla sodales venenatis vestibulum. Ut eu felis nisi. Phasellus efficitur imperdiet erat a vehicula. Suspendisse quis vestibulum leo. Maecenas ultricies urna ligula, cursus malesuada justo porttitor ut.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('10/16/2015'));
        $document->setFinDeVie(new \DateTime('01/01/2018'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Catalogue des formations 2016');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('ANACT');
        $document->setResume('Donec dictum, augue id congue sagittis, diam turpis egestas sapien, ac placerat velit magna quis augue. Nulla facilisi. Maecenas elementum ornare eros, ut iaculis dui condimentum quis. Nunc commodo, risus nec vehicula suscipit, felis lacus dapibus massa, at efficitur mi mi quis nulla. Nam urna enim, maximus non laoreet ut, viverra nec risus. Cras mi massa, volutpat et massa ut, tempus cursus eros. Vestibulum ultricies, risus id hendrerit feugiat, diam nibh elementum diam, a tempus diam libero nec lacus. Sed elementum finibus nunc ac egestas. Ut id leo ut ex elementum varius. Curabitur magna mi, porta eget risus sit amet, auctor dictum nunc. Aliquam vitae ex eget justo condimentum fermentum mattis eu orci. Vestibulum ut est velit. Fusce leo tortor, tincidunt eget purus at, tincidunt aliquet nisl. Cras eu vestibulum nisl.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/20/2015'));
        $document->setFinDeVie(new \DateTime('05/01/2017'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Les brevets issus de la recherche publique');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('INPI');
        $document->setResume('Vestibulum sed dui lacinia, eleifend sem at, vehicula mi. Maecenas fermentum efficitur gravida. Donec congue maximus nunc, non dignissim augue cursus id. In est elit, iaculis ac lectus a, tristique consequat augue. Maecenas elementum pretium mauris, id sodales massa mattis et. Cras mollis tortor non nulla consequat, ac mattis ligula pulvinar. Quisque non iaculis magna, sed luctus dolor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis vulputate tincidunt luctus. Suspendisse eu lacinia justo. Sed quis tellus suscipit neque ultricies dignissim ut eget magna. Duis quis ex elit. Maecenas vel odio a orci consectetur imperdiet vitae sit amet libero. Pellentesque non fringilla lorem.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/23/2015'));
        $document->setFinDeVie(new \DateTime('04/01/2019'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Bilan économique 2014 du Centre-Val de Loire');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('INSEE');
        $document->setResume('Duis a porta ex. Donec vel molestie velit, sit amet vehicula magna. Phasellus sagittis tellus ut sem cursus iaculis sit amet sit amet leo. Suspendisse dui velit, malesuada nec magna sed, varius facilisis elit. Morbi vel fermentum massa. In laoreet dui orci, in laoreet tellus volutpat in. Cras consequat vestibulum est eu varius. Maecenas bibendum dolor a nibh pulvinar congue.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('07/27/2015'));
        $document->setFinDeVie(new \DateTime('09/01/2017'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Rapport Numérique et libertés : un nouvel âge démocratique');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('Assemblée nationale');
        $document->setResume('Aenean eu magna tempus, viverra velit a, ultrices est. Mauris in magna tellus. Integer ac sapien fringilla, placerat metus eu, congue nulla. Cras et risus ac augue pulvinar molestie a at tellus. Nulla sed tellus nisi. Vivamus accumsan, purus eu ullamcorper euismod, enim est placerat magna, ac egestas leo est nec metus. Donec vel aliquet dolor. Suspendisse eget justo at nisi commodo tincidunt. Nam nec dignissim enim, non eleifend risus.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('09/04/2015'));
        $document->setFinDeVie(new \DateTime('06/01/2016'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('La qualité du travail au cœur de la formation');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('ANACT');
        $document->setResume('Nullam semper arcu ac ligula gravida accumsan id ut sapien. Nullam ultrices, eros in rhoncus luctus, massa ligula blandit arcu, vitae auctor augue libero et magna. Quisque facilisis velit enim, id tincidunt magna vulputate in. Aliquam ultricies lorem diam, at gravida sem tempor ut. Morbi vel lacus lectus. In egestas urna ut luctus scelerisque. Cras pellentesque urna id ornare viverra. Nulla blandit odio et dapibus luctus.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('05/14/2015'));
        $document->setFinDeVie(new \DateTime('02/01/2018'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Exigences de base pour prestataires de services');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('AFNOR');
        $document->setResume('Etiam auctor felis urna, eu dapibus augue pharetra sit amet. Sed vel tellus ligula. Suspendisse ultrices, justo sit amet lobortis auctor, ex dui venenatis nulla, at faucibus erat elit vel nulla. Vivamus lorem nisi, pellentesque ullamcorper leo id, placerat tincidunt ipsum. Suspendisse scelerisque consequat posuere. Phasellus tempus diam at diam commodo, at suscipit enim lobortis. Ut tempor tempor ipsum, sagittis ornare massa suscipit vel. Praesent maximus mi et efficitur dictum. Praesent tincidunt hendrerit nisi sed tincidunt. Donec scelerisque orci at odio porttitor, non dignissim justo suscipit. Suspendisse sapien libero, vehicula ut nisl sit amet, accumsan scelerisque turpis. Nullam et est quam. Duis convallis, eros vel hendrerit ultricies, enim mi posuere odio, sed gravida mi ligula at tellus. Nam molestie placerat sapien, vel molestie est elementum sed. Aliquam dolor metus, dignissim nec justo eget, suscipit dictum libero. In vehicula aliquet lacinia.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('05/02/2015'));
        $document->setFinDeVie(new \DateTime('01/01/2017'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Rapport relatif à l’Etat actionnaire 2014-2015');
        $document->setUser($this->getReference('uploader-admin'));
        $document->setAuteur('APE');
        $document->setResume('Sed ac nisl at enim faucibus pharetra. Vestibulum fermentum non est sed pharetra. Ut laoreet, diam eget feugiat iaculis, magna quam consequat turpis, sit amet mattis sem elit eu sem. Quisque accumsan urna est, ac accumsan urna lobortis non. Nullam odio mi, mattis et eros ac, mollis tincidunt nibh. Cras dignissim, tortor nec pharetra euismod, est ex tempor dui, a posuere leo est a nibh. Duis eget feugiat urna, in suscipit eros. In egestas lacus id venenatis iaculis. Fusce at est eget est semper congue. Aenean eu lacinia est. Curabitur sem ante, imperdiet eget consectetur ut, elementum vel erat.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/09/2015'));
        $document->setFinDeVie(new \DateTime('03/01/2016'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Projet de loi de programmation des finances publiques');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('Assemblée nationale');
        $document->setResume('Aenean quis sodales tellus. Nulla mattis ex in sollicitudin consectetur. Aenean vehicula dapibus gravida. Etiam at tempor lacus. Mauris nec blandit leo, eget fermentum justo. Integer in vehicula lectus. Pellentesque maximus cursus tellus, non vestibulum ex suscipit in. Nam massa neque, viverra eget nunc interdum, iaculis sodales justo. Nulla posuere leo ut sapien ultricies, efficitur semper erat ullamcorper. Aliquam erat volutpat. Mauris sagittis sem ligula, a egestas lorem dapibus a. Mauris venenatis vel arcu nec dapibus.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('08/18/2015'));
        $document->setFinDeVie(new \DateTime('07/01/2017'));
        $manager->persist($document);

        $document = new Documents();
        $document->setTitre('Mettre en oeuvre un accompagnement éducatif');
        $document->setUser($this->getReference('uploader-superadmin'));
        $document->setAuteur('CNED');
        $document->setResume('Donec tempus leo vel enim semper imperdiet. Etiam egestas lectus tortor, sed fringilla tortor pulvinar sit amet. In ut dolor ac sapien feugiat placerat. Phasellus eu risus hendrerit, commodo lacus sodales, tempor elit. Mauris arcu ipsum, consectetur et enim sit amet, venenatis iaculis nisi.');
        $document->createFile("pdf");
        $document->setFileName('test_upload.pdf');
        $document->setDateUpload(new \DateTime('10/05/2015'));
        $document->setFinDeVie(new \DateTime('08/01/2020'));
        $manager->persist($document);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
