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
}
