<?php

namespace ActuBundle\Controller;

use AgendaBundle\Entity\Events;
use FormBundle\Entity\Formations;
use GedBundle\Entity\Documents;
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

        $actus = $this->container->get('app.actu')->getActualites();

        return $this->render('ActuBundle:Actu:index.html.twig', array(
            'actus' => $actus

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

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

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

        return $this->render('ActuBundle:Actu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Modifier'));

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
     * Remove an existing record or un-checked doc, event, or formation.
     *
     */
    public function deleteAction($id, $type) {

        $em = $this->getDoctrine()->getManager();

        $actus = $this->container->get('app.actu')->getActualitesById($id);

        foreach ($actus as $actu)
        {
            if($type == 'Documents' && $actu instanceof Documents)
            {
                $actu->setFilActu(false);
                $em->flush();
            }
            elseif($type == 'Evènement' && $actu instanceof Events)
            {
                $actu->setFilActu(false);
                $em->flush();
            }
            elseif($type == 'Formations' && $actu instanceof Formations)
            {
                $actu->setFilActu(false);
                $em->flush();
            }
            elseif ($type == 'Actualité' && $actu instanceof Actu)
            {
                $em->remove($actu);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('actu', array(
            'actus' => $actus
        )));
    }
}
