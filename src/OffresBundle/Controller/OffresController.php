<?php

namespace OffresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OffresBundle\Entity\Offres;
use OffresBundle\Form\OffresType;

/**
 * Offres controller.
 *
 */
class OffresController extends Controller
{

    /**
     * Lists all Offres entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OffresBundle:Offres')->findAll();

        return $this->render('OffresBundle:Offres:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Offres entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Offres();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setDateAjout(new \DateTime());
            $entity->setUser($this->get('security.token_storage')->getToken()->getUser());

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('offres-emploi', array('id' => $entity->getId())));
        }

        return $this->render('OffresBundle:Offres:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Offres entity.
     *
     * @param Offres $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Offres $entity)
    {
        $form = $this->createForm(new OffresType(), $entity, array(
            'action' => $this->generateUrl('offres-emploi__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Offres entity.
     *
     */
    public function newAction()
    {
        $entity = new Offres();
        $form   = $this->createCreateForm($entity);

        return $this->render('OffresBundle:Offres:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Offres entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OffresBundle:Offres')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offres entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OffresBundle:Offres:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Offres entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OffresBundle:Offres')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offres entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OffresBundle:Offres:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Offres entity.
    *
    * @param Offres $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Offres $entity)
    {
        $form = $this->createForm(new OffresType(), $entity, array(
            'action' => $this->generateUrl('offres-emploi__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Offres entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OffresBundle:Offres')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offres entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('offres-emploi__edit', array('id' => $id)));
        }

        return $this->render('OffresBundle:Offres:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Offres entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OffresBundle:Offres')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Offres entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('offres-emploi_'));
    }

    /**
     * Creates a form to delete a Offres entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offres-emploi__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
