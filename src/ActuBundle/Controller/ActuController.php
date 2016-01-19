<?php

namespace ActuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ActuBundle\Entity\Actu;
use ActuBundle\Form\ActuType;

/**
 * Actu controller.
 *
 */
class ActuController extends Controller
{

    /**
     * Lists all Actu entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ActuBundle:Actu')->findAll();

        return $this->render('ActuBundle:Actu:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Actu entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Actu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDateAjout(new \DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actu'));
        }

        return $this->render('ActuBundle:Actu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Actu entity.
     *
     * @param Actu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Actu $entity)
    {
        $form = $this->createForm(new ActuType(), $entity, array(
            'action' => $this->generateUrl('actu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Actu entity.
     *
     */
    public function newAction()
    {
        $entity = new Actu();
        $form   = $this->createCreateForm($entity);

        return $this->render('ActuBundle:Actu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Actu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ActuBundle:Actu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ActuBundle:Actu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Actu entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ActuBundle:Actu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ActuBundle:Actu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Actu entity.
    *
    * @param Actu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Actu $entity)
    {
        $form = $this->createForm(new ActuType(), $entity, array(
            'action' => $this->generateUrl('actu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Actu entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ActuBundle:Actu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('actu_edit', array('id' => $id)));
        }

        return $this->render('ActuBundle:Actu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Actu entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ActuBundle:Actu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Actu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('actu'));
    }

    /**
     * Creates a form to delete a Actu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
