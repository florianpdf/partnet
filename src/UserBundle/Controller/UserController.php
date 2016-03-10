<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use UserBundle\Form\AdminType;
use UserBundle\Form\ContactType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:User')->find($id);
        $entities = $em->getRepository('UserBundle:User')->findAll();
        $list_users = $em->getRepository('UserBundle:User')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException(
                'Pas d\'utilisateur trouvé' . $id
            );
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('annuaire_homepage', array(
            'entity' => $entities,
            'users' => $list_users
        )));
    }

    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Le contact a bien été ajouté à l\'annuaire.');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setRoles(array('ROLE_CONTACT'));
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('annuaire_homepage');
        }

        return $this->render('UserBundle:Registration:contact_register.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    private function createCreateForm($entity)
    {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('fos_user_registration_register_contact'),
            'method' => 'POST',
        ));

        $tokenGenerator = $this->container->get('fos_user.util.token_generator');

        $form->add('password', 'hidden', array(
            'data' => substr($tokenGenerator->generateToken(), 0, 8)))
            ->add('submit', 'submit', array('label' => 'Créer'));
        return $form;
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm()
            ->remove('current_password');
        $form->setData($user);

        $form->handleRequest($request);

        //$user->setPlainPassword($form->get('current_password')->getData());

        if ($form->isValid()) {

            if($form->get('file')->getData() != null) {
                if($user->getPictureName() != null) {
                    unlink(__DIR__.'/../../../app/uploads/profile_pictures/'.$user->getPicture());
                    $user->setPicture(null);
                }
            }

            $user->preUpload();
            $user->setUsername($this->getUser()->getEmail());

            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $raw_tel = $form->get('telephone')->getData();
            $user->setTelephone(str_replace(" ", "", $raw_tel));

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
