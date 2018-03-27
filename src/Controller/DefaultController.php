<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/{_locale}", name="homepage", requirements={"_locale":"en|fr|de"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');
    }
}
