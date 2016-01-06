<?php

namespace AgendaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AgendaBundle\Entity\Events;
use UserBundle\Entity\User;

use AgendaBundle\Form\EventsType;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\Response;

/**
 * Events controller.
 *
 */
class EventsController extends Controller
{

    /**
     * Lists all Events entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgendaBundle:Events')->findAll();

        $normalizer = new ObjectNormalizer();

        $encoder = new JsonEncoder();

        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format(\DateTime::ISO8601)
                : '';
        };

        $normalizer->setCallbacks(array('start' => $dateCallback, 'end' => $dateCallback));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($entities, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;
    }

    /**
     * Fonction permettant de determiner la couleur de l'evenement en fonction de l'organisme
     */
    public function colorEvent($entity)
    {
        $organisme = $this->container->get('security.token_storage')->getToken()->getUser()->getOrganisme();

        if ( $organisme == "Pole emploi" ) {
            $entity->setBackgroundColor("red");
        }

        else if ( $organisme == "CAP Emploi" ) {
            $entity->setBackgroundColor("orange");
        }

        else if ( $organisme == "Mission Local" ) {
            $entity->setBackgroundColor("yellow");
        }
    }

    /**
     * Creates a new Events entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Events();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $entity->setIdUser($user);

            $this->colorEvent($entity);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('agenda_homepage'));
        }

        return $this->render('AgendaBundle:Events:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Events entity.
     *
     * @param Events $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Events $entity)
    {
        $form = $this->createForm(new EventsType(), $entity, array(
            'action' => $this->generateUrl('events_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Events entity.
     *
     */
    public function newAction($start)
    {
        $entity = new Events();

        $entity->setStart(new \DateTime($start)); // On définie la date de début d'évènement
        setlocale(LC_TIME, "fr_FR");

        $startTime = new \DateTime($start);
        $startTime = strftime("%A %e %B %Y à %k:%M", $startTime->getTimestamp());

        // On définie une date de fin min avec un interval de 30 min
        $startEvent = new \DateTime($start);
        $interval = 1800;
        $startEvent->add((new \DateInterval('PT' . $interval . 'S' )));
        $endEvent = $startEvent->format('d-m-Y H:i:s');

        $entity->setEnd(new \DateTime($endEvent));

        $form   = $this->createCreateForm($entity);

        return $this->render('AgendaBundle:Events:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'startTime' =>$startTime,
        ));

    }

    /**
     * Finds and displays a Events entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgendaBundle:Events')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Events entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgendaBundle:Events:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Events entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgendaBundle:Events')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Events entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgendaBundle:Events:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Events entity.
    *
    * @param Events $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Events $entity)
    {
        $form = $this->createForm(new EventsType(), $entity, array(
            'action' => $this->generateUrl('events_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Events entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgendaBundle:Events')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Events entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('events_edit', array('id' => $id)));
        }

        return $this->render('AgendaBundle:Events:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Events entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgendaBundle:Events')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Events entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('events'));
    }

    /**
     * Creates a form to delete a Events entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
