<?php

namespace GedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GedBundle\Entity\Documents;
use GedBundle\Form\DocumentsType;
use UserBundle\Entity\Statistiques;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list_users = $em->getRepository('UserBundle:User')->findAll();
        $entities = $em->getRepository('GedBundle:Documents')->findAll();

        $this->stats($em);

        return $this->render('GedBundle:Documents:index.html.twig', array(
            'docs' => $entities,
            'users' => $list_users,
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
            $entity->setDateAjout(new \DateTime());
            $entity->setUser($this->get('security.token_storage')->getToken()->getUser());

            $nbUploads = $entity->getUser()->getNbUploads();
            $entity->getUser()->setNbUploads($nbUploads + 1);

            $em->persist($entity);

            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Votre document a bien été ajouté sur le portail.');

            return $this->redirect($this->generateUrl('documents'));
        }

        return $this->render('GedBundle:Documents:new.html.twig', array(
            'doc' => $entity,
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

        $form->add('submit', 'submit', array('label' => 'Envoyer'));

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
            'doc' => $entity,
            'form'   => $form->createView(),
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

        return $this->render('GedBundle:Documents:edit.html.twig', array(
            'doc'      => $entity,
            'edit_form'   => $editForm->createView(),
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
        $form = $this->createForm(new DocumentsType(), $entity, array(
            'action' => $this->generateUrl('documents_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Éditer'));
        $form->remove('file');

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

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre document a bien été modifié.');


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->preUpload();

            $em->flush();

            return $this->redirect($this->generateUrl('documents'));
        }

        return $this->render('GedBundle:Documents:edit.html.twig', array(
            'doc'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Remove an existing record and a file.
     *
     */
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
            'docs' => $entities,
            'users' => $list_users
        )));
    }

    /**
     * Download an existing file.
     *
     */
    public function DownloadAction($document)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GedBundle:Documents')->findOneBy(array('document'=> $document));
        $filename = $entity->getFileName();

        // Generate response
        $response = new Response();

        $filepath = $this->get('kernel')->getRootDir()."/uploads/documents/";
        $content = file_get_contents($filepath.$document);

        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);

        return $response;
    }

    public function VisualAction($document)
    {
        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir()."/uploads/documents/". $document;

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

    public function stats($em)
    {
        $statistiques = $em->getRepository('UserBundle:Statistiques');

        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        if ($statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime())) == null){
            $stats = new Statistiques();
            $stats->setUser($current_user);
            $stats->setDate(new \DateTime());
            $stats->setNbVisitesGed(+1);
            $em->persist($stats);
            $em->flush();
        }
        else {
            $stats = $statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime()));
            $stats->setNbVisitesGed($stats->getNbVisitesGed() + 1);
            $em->flush();
        }
    }
}
