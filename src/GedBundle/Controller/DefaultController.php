<?php

namespace GedBundle\Controller;

use GedBundle\Entity\Documents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!$this->getUser())
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $document = new Documents();

        $document->setDateUpload(new \DateTime());
        $document->setUser($this->container->get('security.context')->getToken()->getUser());

        $form = $this->createForm('document', $document);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $document->getUrl();
            $document->setExtension($file->getClientOriginalExtension());

            if ($document->getExtension() == 'pdf') {
                $fileName = $file->getClientOriginalName();
                $documentsDir = $this->container->getParameter('kernel.root_dir').'/../app/uploads/documents';
                $file->move($documentsDir, $fileName);
                $document->setUrl($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($document);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Votre document a bien été ajouté sur le portail.');

                return $this->redirectToRoute('ged_homepage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('failure', 'Le type de fichier n\'est pas supporté.');
            }
        }

        // Doctrine : get all documents and users
        $em = $this->getDoctrine()->getManager();
        $list_docs = $em->getRepository('GedBundle:Documents')->findAll();
        $list_users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('GedBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'docs' => $list_docs,
            'users' => $list_users
        ));
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
