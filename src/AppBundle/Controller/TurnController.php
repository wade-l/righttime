<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Turn;
use AppBundle\Entity\DowntimePeriod;
use AppBundle\Entity\Character;
use AppBundle\Entity\Act;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


/**
 * Turn controller.
 *
 * @Route("turn")
 */
class TurnController extends Controller
{
    /**
     * Lists all turn entities.
     *
     * @Route("/", name="turn_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $turns = $em->getRepository('AppBundle:Turn')->findAll();

        return $this->render('turn/index.html.twig', array(
            'turns' => $turns,
        ));
    }

    /**
     * Edits or creates a turn entity.
     *
     * @Route("/edit/{downtime_id}/character/{character_id}", name="turn_new")
     * @ParamConverter("period", class="AppBundle:DowntimePeriod", options={"id" = "downtime_id"})
     * @ParamConverter("character", class="AppBundle:Character", options={"id" = "character_id"})
     * 
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DowntimePeriod $period, Character $character)
    {
        $turn = $this->getDoctrine()
            ->getRepository(Turn::class)
            ->findByPeriodAndCharacter($period, $character);

        if ( $turn == null) {
            $turn = new Turn();
            $turn->setDowntimePeriod($period);
            $turn->setCharacter($character);
        }
        
        $form = $this->createForm('AppBundle\Form\TurnType', $turn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turn);
            $em->flush();

            return $this->redirectToRoute('turn_show', array('id' => $turn->getId()));
        }

        return $this->render('turn/edit.html.twig', array(
            'turn' => $turn,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a turn entity.
     *
     * @Route("/{id}", name="turn_show")
     * @Method("GET")
     */
    public function showAction(Turn $turn)
    {
        $deleteForm = $this->createDeleteForm($turn);

        return $this->render('turn/show.html.twig', array(
            'turn' => $turn,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a turn entity.
     *
     * @Route("/{id}", name="turn_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Turn $turn)
    {
        $form = $this->createDeleteForm($turn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($turn);
            $em->flush();
        }

        return $this->redirectToRoute('turn_index');
    }

    /**
     * Creates a form to delete a turn entity.
     *
     * @param Turn $turn The turn entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Turn $turn)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('turn_delete', array('id' => $turn->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
