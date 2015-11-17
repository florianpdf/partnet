<?php

namespace GedBundle\Controller;

use GedBundle\Entity\Documents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\Validator\Constraints\Date;

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
            // Upload du fichier
            $file = $document->getUrl();
            $fileName = $file->getClientOriginalName();
            $documentsDir = $this->container->getParameter('kernel.root_dir').'/../app/uploads/documents';
            $file->move($documentsDir, $fileName);
            $document->setUrl($fileName);
            $document->setExtension($file->getClientOriginalExtension());

            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();
            return $this->redirectToRoute('ged_homepage');
        }

        return $this->render('GedBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
