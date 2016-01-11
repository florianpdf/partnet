<?php

namespace AgendaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AgendaBundle\Entity\Events;

use AgendaBundle\Form\EventsType;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;


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

        if ( $organisme == "Pôle emploi" ) {
            $entity->setBackgroundColor("red");
        }
        else if ( $organisme == "Cap emploi" ) {
            $entity->setBackgroundColor("orange");
        }

        else if ( $organisme == "Mission locale" ) {
            $entity->setBackgroundColor("blue");
        }
        else if ( $organisme == "Sous-préfecture" ) {
            $entity->setBackgroundColor("green");
        }
        else if ( $organisme == "DIRECCTE" ) {
            $entity->setBackgroundColor("purple");
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

        // On récupère la date de début et de fin d'évènement afin de les comparer
        $startEvent = $form->getViewData()->getStart();
        $startEvent_string = strftime("%A %e %B %Y à %k:%M", $startEvent->getTimestamp());
        $endEvent = $form->getViewData()->getEnd();

        if ($form->isValid()) {

            // On détermine la différence entre les heures et les minutes
            $diffTime_min = date_diff($startEvent, $endEvent)->i;
            $diffTime_hour = date_diff($startEvent, $endEvent)->h;

            // Si la durée de l'event est inferieur à une heure, alors, on le met à une heure automatiquement
            if ($diffTime_min <= 59 && $diffTime_hour == 0) {
                date_sub($endEvent, date_interval_create_from_date_string($diffTime_min . 'min'));
                $entity->setEnd($endEvent->modify('+1 hours'));
            }

            $em = $this->getDoctrine()->getManager();

            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $entity->setTitre(htmlspecialchars($form->getViewData()->getTitre()));
            $entity->setContenu(htmlspecialchars($form->getViewData()->getContenu()));
            $entity->setIdUser($user);

            $this->colorEvent($entity);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('agenda_homepage'));
        }

        return $this->render('AgendaBundle:Events:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'startEvent' => $startEvent_string,
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

        $form->add('submit', 'submit', array('label' => 'Créer l\'évènement'));

        return $form;
    }

    /**
     * Displays a form to create a new Events entity.
     *
     */
    public function newAction($start)
    {
        $entity = new Events();
        // On définie la date de début d'évènement
        $entity->setStart(new \DateTime($start));

        // Permet l'affichage de la date et l'heure en format fr
        setlocale(LC_TIME, "fr_FR");
        $startEvent = new \DateTime($start);
        $startEvent = strftime("%A %e %B %Y à %k:%M", $startEvent->getTimestamp());

        // On définie une date de fin min avec un interval de 30 min
        $newTime = new \DateTime($start);
        $interval = 3600;
        $newTime->add(new \DateInterval('PT' . $interval . 'S' ));
        $endEvent = $newTime->format('d-m-Y H:i:s');

        $entity->setEnd(new \DateTime($endEvent));

        $form   = $this->createCreateForm($entity);

        return $this->render('AgendaBundle:Events:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'startEvent' => $startEvent,
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
        $form->add('start', 'datetime', array('label' => 'Début de l\'évènement'));

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

            $entity->setTitre(htmlspecialchars($entity->getTitre()));
            $entity->setContenu(htmlspecialchars($entity->getContenu()));

            $em->flush();

            return $this->redirect($this->generateUrl('agenda_homepage'));
        }

        return $this->render('AgendaBundle:Events:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgendaBundle:Events')->find($id);
        $entities = $em->getRepository('AgendaBundle:Events')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('agenda_homepage'));
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
