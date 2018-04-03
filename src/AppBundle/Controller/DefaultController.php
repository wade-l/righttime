<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $games_organized = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->findAllByUserAndPosition($this->getUser(), 'organizer');
        
        return $this->render('default/index.html.twig', array(
            'user'=> $this->getUser(),
            'games_organized'=> $games_organized,
        ));
    }
}
