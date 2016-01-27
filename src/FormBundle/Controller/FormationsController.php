<?php

namespace FormBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FormBundle\Entity\Formations;
use FormBundle\Form\FormationsType;


use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Formations controller.
 *
 */
class FormationsController extends Controller
{

    /**
     * Download an existing file.
     *
     */
    public function DownloadAction($fichier)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FormBundle:Formations')->findOneBy(array('fichier'=> $fichier));
        $filename = $entity->getFichier();

        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/formations_documents/". $fichier;

        $oFile = new File($filepath);

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $oFile->getMimeType());
        $response->headers->set('Content-Disposition', 'attachment; filepath="' . $oFile->getBasename() . '";');
        $response->headers->set('Content-length', $oFile->getSize());
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);                                    // filename

        $response->headers->set('Content-Disposition', $d);

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filepath));

        return $response;
    }

    public function DownloadSecondAction($fichier)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FormBundle:Formations')->findOneBy(array('second_fichier' => $fichier));
        $filename = $entity->getSecondFichier();

        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/formations_documents/". $fichier;

        $oFile = new File($filepath);

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $oFile->getMimeType());
        $response->headers->set('Content-Disposition', 'attachment; filepath="' . $oFile->getBasename() . '";');
        $response->headers->set('Content-length', $oFile->getSize());
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);                                    // filename

        $response->headers->set('Content-Disposition', $d);

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filepath));

        return $response;
    }

    public function VisualAction($document)
    {
        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/formations_documents/". $document;

        $oFile = new File($filepath);

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $oFile->getMimeType());
        $response->headers->set('Content-Disposition', 'inline; filepath="' . $oFile->getBasename() . '";');
        $response->headers->set('Content-length', $oFile->getSize());                                  // filename


        // Send headers before outputting anything
        $response->sendHeaders();
        $response->setContent(file_get_contents($filepath));

        return $response;
    }

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

//            $entity->setImage($this->getUser()->getIdOrganisme()->getPhoto());

            $entity->setDateAjout(new \DateTime());
            $entity->setUser($this->get('security.token_storage')->getToken()->getUser());

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


           // Edition upload
            if($editForm->get('file')->getData() != null) {
                if($entity->getFichier() != null) {
                    unlink(__DIR__.'/../../../app/uploads/formations_documents/'.$entity->getFichier());
                    $entity->setFichier(null);
                }
            }

            if($editForm->get('file2')->getData() != null) {
                if($entity->getSecondFichier() != null) {
                    unlink(__DIR__.'/../../../app/uploads/formations_documents/'.$entity->getSecondFichier());
                    $entity->setSecondFichier(null);
                }
            }
            $entity->preUploadFile1();
            $entity->preUploadFile2();

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

