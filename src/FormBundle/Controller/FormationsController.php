<?php

namespace FormBundle\Controller;

use AppBundle\Entity\Organisme;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FormBundle\Entity\Formations;
use FormBundle\Form\FormationsType;
use FormBundle\Entity\FormationsRepository;
use Symfony\Component\Security\Core\User\User;

/**
 * Formations controller.
 *
 */
class FormationsController extends Controller
{

    /**
     * Lists all Formations entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $entities = $em->getRepository('FormBundle:Formations')->findAll();

        return $this->render('FormBundle:Formations:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Formations entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Formations();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setImage($this->getUser()->getIdOrganisme()->getPhoto());

            $entity->setDateAjout(new \DateTime());

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formations'));
        }

        return $this->render('FormBundle:Formations:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Formations entity.
     *
     * @param Formations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Formations $entity)
    {
        $form = $this->createForm(new FormationsType(), $entity, array(
            'action' => $this->generateUrl('formations_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Formations entity.
     *
     */
    public function newAction()
    {
        $entity = new Formations();
        $form   = $this->createCreateForm($entity);


        return $this->render('FormBundle:Formations:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Formations entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormBundle:Formations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formations entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('FormBundle:Formations:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Formations entity.
    *
    * @param Formations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Formations $entity)
    {
        $form = $this->createForm(new FormationsType(), $entity, array(
            'action' => $this->generateUrl('formations_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Éditer'));

        return $form;
    }
    /**
     * Edits an existing Formations entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FormBundle:Formations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formations entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formations'));
        }

        return $this->render('FormBundle:Formations:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Formations entity.
     *
     */
    public function deleteAction($id)
    {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FormBundle:Formations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formations entity.');
            }

            $em->remove($entity);
            $em->flush();


        return $this->redirect($this->generateUrl('formations'));
    }

    /**
     * Creates a form to delete a Formations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

}
