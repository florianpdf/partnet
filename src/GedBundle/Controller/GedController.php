<?php

namespace GedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GedController extends Controller
{
    public function indexAction()
    {
        return $this->render('GedBundle:ged:ged_homepage.html.twig');
    }
}