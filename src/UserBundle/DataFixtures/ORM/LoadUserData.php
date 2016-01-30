<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $superadmin = $userManager->createUser();
        $superadmin->setUsername('superadmin');
        $superadmin->setEmail('superadmin@superadmin.com');
        $superadmin->setPlainPassword('superadmin');
        $superadmin->setEnabled(true);
        $superadmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $superadmin->setNom('Dumont');
        $superadmin->setPrenom('Christophe');
        $superadmin->setIdOrganisme($this->getReference(1));
        $superadmin->setPoste('Directeur');
        $superadmin->setTelephone('0389126433');
        $superadmin->setNbUploads('0');
        $superadmin->setCreationCompte(new \DateTime('01/01/2016'));
        //$superadmin->setLastLogin(new \DateTime(''));
        $userManager->updateUser($superadmin);

        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setNom('Fournier');
        $admin->setPrenom('Antoine');
        $admin->setIdOrganisme($this->getReference(2));
        $admin->setPoste('Directeur');
        $admin->setTelephone('0378254167');
        $admin->setNbUploads('0');
        $admin->setCreationCompte(new \DateTime('01/15/2016'));
        //$admin->setLastLogin(new \DateTime(''));
        $userManager->updateUser($admin);

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@user.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $user->setNom('Perrin');
        $user->setPrenom('Émilie');
        $user->setIdOrganisme($this->getReference(3));
        $user->setPoste('Chargée d\'accueil');
        $user->setTelephone('0368474510');
        $user->setNbUploads('0');
        $user->setCreationCompte(new \DateTime('05/01/2016'));
        //$user->setLastLogin(new \DateTime(''));
        $userManager->updateUser($user);

//        $user = $userManager->createUser();
//        $user->setUsername('ludovic_sarrazin');
//        $user->setEmail('ludovic_sarrazin@ludovic_sarrazin.com');
//        $user->setPlainPassword('ludo');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_SUPER_ADMIN'));
//        $user->setNom('Sarrazin');
//        $user->setPrenom('Ludovic');
//        $user->setIdOrganisme($this->getReference(3));
//        $user->setPoste('Directeur');
//        $user->setTelephone('0000000000');
//        $user->setNbUploads('14');
//        $user->setCreationCompte(new \DateTime('05/01/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('carole_bouclet');
//        $user->setEmail('carole_bouclet@carole_bouclet.com');
//        $user->setPlainPassword('caro');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_USER'));
//        $user->setNom('Bouclet');
//        $user->setPrenom('Carole');
//        $user->setIdOrganisme($this->getReference(2));
//        $user->setPoste('Directeur adjoint');
//        $user->setTelephone('0000000000');
//        $user->setNbUploads('9');
//        $user->setCreationCompte(new \DateTime('01/13/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('pascale_rodrigo');
//        $user->setEmail('pascale_rodrigo@pascale_rodrigo.com');
//        $user->setPlainPassword('pascale');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_ANNUAIRE_ADMIN'));
//        $user->setNom('Rodrigo');
//        $user->setPrenom('Pascale');
//        $user->setIdOrganisme($this->getReference(2));
//        $user->setPoste('Directrice');
//        $user->setTelephone('1111111111');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/05/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('valerie_legroux');
//        $user->setEmail('valerie_legroux@valerie_legroux.com');
//        $user->setPlainPassword('val');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_USER'));
//        $user->setNom('Legroux');
//        $user->setPrenom('Valerie');
//        $user->setIdOrganisme($this->getReference(3));
//        $user->setPoste('Chargée d\'accueil');
//        $user->setTelephone('2222222222');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/25/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('celine_jacquemard');
//        $user->setEmail('celine_jacquemard@celine_jacquemard.com');
//        $user->setPlainPassword('jac');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_ANNUAIRE_ADMIN'));
//        $user->setNom('Jacquemard');
//        $user->setPrenom('Céline');
//        $user->setIdOrganisme($this->getReference(3));
//        $user->setPoste('Chargée relation entreprise');
//        $user->setTelephone('3333333333');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/25/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('franceline_forterre_chapard');
//        $user->setEmail('franceline_forterre_chapard@franceline_forterre_chapard.com');
//        $user->setPlainPassword('franc');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_OFFRE_ADMIN'));
//        $user->setNom('Forterre Chapard');
//        $user->setPrenom('Franceline');
//        $user->setIdOrganisme($this->getReference(5));
//        $user->setPoste('Sous prefet');
//        $user->setTelephone('4444444444');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/252016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('florence_parachout');
//        $user->setEmail('florence_parachout@florence_parachout.com');
//        $user->setPlainPassword('flo');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_FORMATION_ADMIN'));
//        $user->setNom('Parachout');
//        $user->setPrenom('Florence');
//        $user->setIdOrganisme($this->getReference(5));
//        $user->setPoste('Responsable pôle formation');
//        $user->setTelephone('5555555555');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/23/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('mathilde_capron');
//        $user->setEmail('mathilde_capron@mathilde_capron.com');
//        $user->setPlainPassword('mat');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_OFFRE_ADMIN'));
//        $user->setNom('Capron');
//        $user->setPrenom('Mathilde');
//        $user->setIdOrganisme($this->getReference(4));
//        $user->setPoste('Chargée de mission secteuts');
//        $user->setTelephone('5555555555');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/22/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('michel_clérot');
//        $user->setEmail('michel_clérot@michel_clérot.com');
//        $user->setPlainPassword('mich');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_FORMATION_ADMIN'));
//        $user->setNom('Clérot');
//        $user->setPrenom('Michel');
//        $user->setIdOrganisme($this->getReference(4));
//        $user->setPoste('Chargée de mission secteuts');
//        $user->setTelephone('6666666666');
//        $user->setNbUploads('0');
//        $user->setCreationCompte(new \DateTime('01/22/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('sophie_tondelier');
//        $user->setEmail('sophie_tondelier@sophie_tondelier.com');
//        $user->setPlainPassword('sophie');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_USER'));
//        $user->setNom('Tondelier');
//        $user->setPrenom('Sophie');
//        $user->setIdOrganisme($this->getReference(4));
//        $user->setPoste('Directrice');
//        $user->setTelephone('7777777777');
//        $user->setNbUploads('24');
//        $user->setCreationCompte(new \DateTime('01/12/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('albéric_de_montgolfier');
//        $user->setEmail('albéric_de_montgolfier@albéric_de_montgolfier.com');
//        $user->setPlainPassword('sophie');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_ADMIN'));
//        $user->setNom('De Montgolfier');
//        $user->setPrenom('Albéric');
//        $user->setIdOrganisme($this->getReference(6));
//        $user->setPoste('Président du conseil');
//        $user->setTelephone('7777777777');
//        $user->setNbUploads('24');
//        $user->setCreationCompte(new \DateTime('01/12/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('laurent_lepine');
//        $user->setEmail('laurent_lepine@laurent_lepine.com');
//        $user->setPlainPassword('laurent');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_FORMATION_ADMIN'));
//        $user->setNom('Lépine');
//        $user->setPrenom('Laurent');
//        $user->setIdOrganisme($this->getReference(6));
//        $user->setPoste('Directeur adjoint des solidarités');
//        $user->setTelephone('8888888888');
//        $user->setNbUploads('4');
//        $user->setCreationCompte(new \DateTime('01/18/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
//        $user = $userManager->createUser();
//        $user->setUsername('jerome_moreau');
//        $user->setEmail('jerome_moreau@jerome_moreau.com');
//        $user->setPlainPassword('jerome');
//        $user->setEnabled(true);
//        $user->setRoles(array('ROLE_USER'));
//        $user->setNom('Moreau');
//        $user->setPrenom('Jérome');
//        $user->setIdOrganisme($this->getReference(2));
//        $user->setPoste('Directeur');
//        $user->setTelephone('9999999999');
//        $user->setNbUploads('19');
//        $user->setCreationCompte(new \DateTime('01/10/2016'));
//        //$user->setLastLogin(new \DateTime(''));
//        $userManager->updateUser($user);
//
        $this->addReference('uploader-user', $user);
        $this->addReference('uploader-admin', $admin);
        $this->addReference('uploader-superadmin', $superadmin);
    }

    public function getOrder()
    {
        return 2;
    }
}
