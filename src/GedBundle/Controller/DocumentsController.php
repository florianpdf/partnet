<?php

namespace GedBundle\Controller;

use GedBundle\Form\EditDocType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GedBundle\Entity\Documents;
use GedBundle\Form\DocumentsType;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;


/**
 * Documents controller.
 *
 */
class DocumentsController extends Controller
{

    /**
     * Lists all Documents entities.
     *
     */
    public function indexAction(Request $request)
    {
        if (!$this->getUser())
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $list_users = $em->getRepository('UserBundle:User')->findAll();
        $entities = $em->getRepository('GedBundle:Documents')->findAll();

        $entity = new Documents();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        return $this->render('GedBundle:Documents:index.html.twig', array(
            'entities' => $entities,
            'users' => $list_users,
            'form'   => $form->createView(),
        ));

    }
    /**
     * Creates a new Documents entity.
     *
     */

    public function createAction(Request $request)
    {
        $entity = new Documents();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDateUpload(new \DateTime());
            $entity->setUser($this->get('security.token_storage')->getToken()->getUser());

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documents', array('id' => $entity->getId())));
        }

        return $this->render('GedBundle:Documents:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Documents entity.
     *
     * @param Documents $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Documents $entity)
    {
        $form = $this->createForm(new DocumentsType(), $entity, array(
            'action' => $this->generateUrl('documents_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Documents entity.
     *
     */
    public function newAction()
    {
        $entity = new Documents();
        $form   = $this->createCreateForm($entity);

        return $this->render('GedBundle:Documents:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Documents entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GedBundle:Documents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documents entity.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GedBundle:Documents:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Documents entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GedBundle:Documents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documents entity.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GedBundle:Documents:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Documents entity.
    *
    * @param Documents $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Documents $entity)
    {
        $form = $this->createForm(new EditDocType(), $entity, array(
            'action' => $this->generateUrl('documents_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Documents entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GedBundle:Documents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documents entity.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->preUpload();
            $em->flush();

            return $this->redirect($this->generateUrl('documents_edit', array('id' => $id)));
        }

        return $this->render('GedBundle:Documents:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
//    /**
//     * Deletes a Documents entity.
//     *
//     */
//    public function deleteAction(Request $request, $id)
//    {
//        $form = $this->createDeleteForm($id);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $entity = $em->getRepository('GedBundle:Documents')->find($id);
//
//            if (!$entity) {
//                throw $this->createNotFoundException('Unable to find Documents entity.');
//            }
//
//            $em->remove($entity);
//            $em->flush();
//        }
//
//        return $this->redirect($this->generateUrl('documents'));
//    }
//
//    /**
//     * Creates a form to delete a Documents entity by id.
//     *
//     * @param mixed $id The entity id
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm($id)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('documents_delete', array('id' => $id)))
//            ->setMethod('DELETE')
//            ->add('submit', 'submit', array('label' => 'Delete'))
//            ->getForm()
//        ;
//    }

    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GedBundle:Documents')->find($id);
        $entities = $em->getRepository('GedBundle:Documents')->findAll();
        $list_users = $em->getRepository('UserBundle:User')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('documents', array(
            'entities' => $entities,
            'users' => $list_users
        )));
    }

    public function dlAction($filename)
    {
        if (!$this->getUser())
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/documents/".$filename;

        $oFile = new File($filepath);
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $oFile->getMimeType());
        $response->headers->set('Content-Disposition', 'attachment; filepath="' . $oFile->getBasename() . '";');
        $response->headers->set('Content-length', $oFile->getSize());

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filepath));

        return $response;
    }
}
