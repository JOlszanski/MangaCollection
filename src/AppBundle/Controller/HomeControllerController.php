<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class HomeControllerController
 * @package AppBundle\Controller
 * @Method({"GET", "POST"})
 */
class HomeControllerController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     */
    public function indexAction()
    {

        return $this->render('AppBundle:HomeController:index.html.twig', array(
            // ...
        ));
    }

}
