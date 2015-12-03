<?php


namespace AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session;
use AnnuaireBundle\Entity\Mail;

class AnnuaireController extends Controller
{


    public function contactAction()
    {
        $enquiry = new Mail();
        $form = $this->createForm(new MailType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                return $this->redirectToRoute('mail');
            }
        }

        return $this->render('AnnuaireBundle:Annuaire:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
