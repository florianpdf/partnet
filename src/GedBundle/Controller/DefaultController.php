<?php

namespace GedBundle\Controller;

use GedBundle\Entity\Documents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\HttpFoundation\Session;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
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

        return $this->render('GedBundle:Default:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
