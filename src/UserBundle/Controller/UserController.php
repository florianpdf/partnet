<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UserBundle\Form\UserType;
use UserBundle\Form\AdminType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        if($this->get('security.context')->isGranted('ROLE_ADMIN') || $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('UserBundle:User')->findAll();

            /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
            $formFactory = $this->get('fos_user.registration.form.factory');
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->get('event_dispatcher');

            $user = $userManager->createUser();
            $user->setEnabled(true);

            // $form = $formFactory->createForm();


            //$form->setData($user);

            return $this->render('UserBundle:User:index.html.twig', array(
                'entities' => $entities,
                //   'form' => $form->createView(),
            ));
        } else {
            return $this->redirectToRoute('homepage');
        }

    }

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

        return $this->redirect($this->generateUrl('user', array(
            'entity' => $entities,
            'users' => $list_users
        )));
    }
}
