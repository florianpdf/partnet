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
        $superadmin->setOrganisme('Pôle emploi');
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
        $admin->setOrganisme('Sous-préfecture');
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
        $user->setOrganisme('Mission locale');
        $user->setPoste('Chargée d\'accueil');
        $user->setTelephone('0368474510');
        $user->setNbUploads('0');
        $user->setCreationCompte(new \DateTime('05/01/2016'));
        //$user->setLastLogin(new \DateTime(''));
        $userManager->updateUser($user);

        $this->addReference('uploader-user', $user);
        $this->addReference('uploader-admin', $admin);
        $this->addReference('uploader-superadmin', $superadmin);
    }

    public function getOrder()
    {
        return 1;
    }
}
