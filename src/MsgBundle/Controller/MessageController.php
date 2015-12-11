<?php

namespace MsgBundle\Controller;

use MsgBundle\Entity\ResponseMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MsgBundle\Entity\Message;
use MsgBundle\Form\MessageType;
use UserBundle\Entity\User;

/**
 * Message controller.
 *
 */
class MessageController extends Controller
{

    public function subjectAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Vérifie les id receveur et compare à l'id de l'utilisateur connecté puis récupère les entités
        $entities = $em->getRepository('MsgBundle:Message')->findByNomSender($this->getUser()->getEmail());
        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('MsgBundle:Message:subject.html.twig', array(
            'entities' => $entities,
            'users' => $users,
        ));
    }
    /**
     * Lists all Message entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupère les messages selon le nom d'utilisateur
        $entities = $em->getRepository('MsgBundle:Message')->findByNomRecipient($this->getUser()->getEmail());

        return $this->render('MsgBundle:Message:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Message entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Message();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Auto completion champ Sender
            $entity->setSender($this->getUser()->getEmail());

            //Auto completion du champ sender_name
            $entity->setSenderName($this->getUser()->getNom().' '.$this->getUser()->getPrenom());

            // Visible dans la boite du receveur, Si il est sur 0 alors il est considéré comme supprimé dans la boite du receveur
            $entity->setVisibleInBoxReceiver(1);
            //Ajout de la date d'envoi
            $entity->setDate(new \DateTime('now'));

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('message_show', array('id' => $entity->getId())));
        }

        return $this->render('MsgBundle:Message:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Message entity.
     *
     * @param Message $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Message $entity)
    {
        $form = $this->createForm(new MessageType(), $entity, array(
            'action' => $this->generateUrl('message_create'),
            'method' => 'POST',
        ));
        $form->add('subject', 'text', array('label' => 'Sujet'));
        $form->add('submit', 'submit', array('label' => 'Envoyer'));

        return $form;
    }

    /**
     * Displays a form to create a new Message entity.
     *
     */
    public function newAction($email = null)
    {
        $entity = new Message();
        $form   = $this->createCreateForm($entity);

        if($email != null)
        {
            return $this->render('MsgBundle:Message:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'selected_email' => $email,
            ));
        } else{
            return $this->render('MsgBundle:Message:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));

        }
    }

    /**
     * Finds and displays a Message entity.
     *
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MsgBundle:Message')->find($id);
        $entities_comments = $em->getRepository('MsgBundle:ResponseMessage')->findAll($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }

        $comment = new ResponseMessage();
        // On génère le formulaire
        $formBuilder = $this->get('form.factory')->createBuilder('form', $comment);
        $formBuilder
            ->add('message', 'textarea')
            ->add('repondre', 'submit');

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Auto completion champ Sender et Id sender
            $comment->setIdMessage($id);
            $comment->setSender($this->getUser()->getEmail());

            //Ajout de la date d'envoi
            $comment->setDate(new \DateTime('now'));

            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('message_show', array('id' => $entity->getId())));
        }


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MsgBundle:Message:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
            'comments' => $entities_comments,
        ));
    }

    /**
     * Deletes a Message entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // recupère le message
            $message = $em->getRepository('MsgBundle:Message')->find($id);

            // recupère les réponses associées au message en question
            $response_message = $em->getRepository('MsgBundle:ResponseMessage')->findByIdMessage($id);

            // si il y'a des réponses au message principal
            if ($response_message != null) {
                // compte le nombre de message et les liste
                for ($i=0; $i < count($response_message); $i++) {
                    // supprime les messages
                    $em->remove($response_message[$i]);
                }
            }

            // supprime le message principal
            $em->remove($message);

            $em->flush();
        }

        return $this->redirect($this->generateUrl('message'));
    }

    /**
     * Creates a form to delete a Message entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer le message'))
            ->getForm()
        ;
    }
}
