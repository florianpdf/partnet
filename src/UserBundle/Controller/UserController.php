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
}
