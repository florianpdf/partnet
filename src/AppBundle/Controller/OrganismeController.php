<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;

use AppBundle\Entity\Organisme;
use AppBundle\Form\OrganismeType;

/**
 * Organisme controller.
 *
 */
class OrganismeController extends Controller
{
    public function DownloadAction($image)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GedBundle:Organisme')->findOneBy(array('photo'=> $image));
        $filename = $entity->getFileName();

        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/documents/". $image;

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


    public function PictureOrganismeAction($picture)
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir() . "/uploads/organismes_pictures/" . $picture;

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

    // GENERATED CODE

    /**
     * Lists all Organisme entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Organisme')->findAll();

        return $this->render('AppBundle:Organisme:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Organisme entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Organisme();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('admin_organisme');
        }

        return $this->render('AppBundle:Organisme:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Organisme entity.
     *
     * @param Organisme $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Organisme $entity)
    {
        $form = $this->createForm(new OrganismeType(), $entity, array(
            'action' => $this->generateUrl('admin_organisme_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Organisme entity.
     *
     */
    public function newAction()
    {
        $entity = new Organisme();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Organisme:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Organisme entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Organisme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organisme entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('AppBundle:Organisme:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),

        ));
    }

    /**
    * Creates a form to edit a Organisme entity.
    *
    * @param Organisme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Organisme $entity)
    {
        $form = $this->createForm(new OrganismeType(), $entity, array(
            'action' => $this->generateUrl('admin_organisme_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));
        return $form;
    }
    /**
     * Edits an existing Organisme entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Organisme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organisme entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_organisme');
        }

        return $this->render('AppBundle:Organisme:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Organisme entity.
     *
     */
    public function deleteAction($id)
    {


            // pour la Méthode GET
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Organisme')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Organisme entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('admin_organisme'));
    }



}
