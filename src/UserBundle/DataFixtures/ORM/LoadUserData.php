<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php
// loading fixtures: php app/console doctrine:fixtures:load (--append)

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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

        $admin = $userManager->createUser();
        $admin->setUsername('Admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setNom('Dumont');
        $admin->setPrenom('Christophe');
        $admin->setOrganisme('Pôle emploi');
        $admin->setPoste('Directeur');
        $admin->setTelephone('0389126433');
        $admin->setNbUploads('0');
        $admin->setCreationCompte(new \DateTime('01/01/2016'));
        //$admin->setLastLogin(new \DateTime(''));
        $userManager->updateUser($admin);

        $admin = $userManager->createUser();
        $admin->setUsername('Admin2');
        $admin->setEmail('admin2@admin2.com');
        $admin->setPlainPassword('admin2');
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
        $user->setUsername('User');
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
    }

    public function getOrder()
    {
        return 1;
    }
}
