<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

class PictureProfileController extends Controller
{
    /**
     * Ce controlleur permet l'affichage de des photos de profile
     */

    public function PictureProfileAction($picture)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        // Generate response
        $response = new Response();

        // Set headers
        $filepath = $this->get('kernel')->getRootDir() . "/uploads/profile_pictures/" . $picture;

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
}