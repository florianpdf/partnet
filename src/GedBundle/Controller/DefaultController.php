<?php

namespace GedBundle\Controller;

use GedBundle\Entity\Documents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $document = new Documents();
        $document->setDateUpload(new \DateTime());

        $form = $this->createForm('document', $document);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();
            return $this->redirectToRoute('documents');
        }

        return $this->render('GedBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
