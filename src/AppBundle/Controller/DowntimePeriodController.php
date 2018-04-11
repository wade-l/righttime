<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DowntimePeriod;
use AppBundle\Entity\Member;
use AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Downtimeperiod controller.
 *
 * @Route("downtimeperiod")
 */
class DowntimePeriodController extends Controller
{
    /**
     * Lists show all downtime periods by game and character
     *
     * @Route("/", name="downtimeperiod_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        //TODO
        $em = $this->getDoctrine()->getManager();

        $downtimePeriods = $em->getRepository('AppBundle:DowntimePeriod')->findAllByPlayer($this->getUser());
        $characters = $turns = $em->getRepository('AppBundle:Character')->findByPlayer($this->getUser());

        return $this->render('downtimeperiod/index.html.twig', array(
            'downtimePeriods' => $downtimePeriods,
            'characters' => $characters,
        ));
    }

    /**
     * Shows organization options for a given game
     *
     * @Route("/organize/{id}", name="downtimeperiod_organize")
     * @Security("is_granted('CAN_ORGANIZE', game)")
     * @Method("GET")
     */
    public function organizeAction(Game $game)
    {
        //TODO
        $em = $this->getDoctrine()->getManager();

        $downtimePeriods = $em->getRepository('AppBundle:DowntimePeriod')->findByGame($game);

        return $this->render('downtimeperiod/organize.html.twig', array(
            'game' => $game,
            'downtimePeriods' => $downtimePeriods,
        ));
    }

    /**
     * Creates a new downtimePeriod entity.
     *
     * @Route("/new/{game_id}", name="downtimeperiod_new")
     * @ParamConverter("game", class="AppBundle:Game", options={"id" = "game_id"})
     * @Security("is_granted('CAN_ORGANIZE', game)")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Game $game)
    {
 
        $downtimePeriod = new Downtimeperiod();
        $downtimePeriod->setGame($game);

        $form = $this->createForm('AppBundle\Form\DowntimePeriodType', $downtimePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($downtimePeriod);
            $em->flush();

            return $this->redirectToRoute('downtimeperiod_show', array('id' => $downtimePeriod->getId()));
        }

        return $this->render('downtimeperiod/new.html.twig', array(
            'downtimePeriod' => $downtimePeriod,
            'form' => $form->createView(),
        ));
    }

    /**
     * Views all turns associated with a downtime period
     *
     * @Route("/viewturns/{id}", name="downtimeperiod_viewturns")
     * @Method("GET")
     * @Security("is_granted('CAN_ORGANIZE', downtimePeriod)")
     */
    public function viewturnsAction(DowntimePeriod $downtimePeriod)
    {
        switch ($format) {
            case "excel":
                return $this->render('downtimeperiod/viewturns.xlsx.twig', array(
                    'downtimePeriod' => $downtimePeriod,
                ));
                break;
            default:
                return $this->render('downtimeperiod/viewturns.html.twig', array(
                    'downtimePeriod' => $downtimePeriod,
                ));
        }
    }

    /**
     * Views all turns associated with a downtime period
     *
     * @Route("/viewturns/{id}/excel", name="downtimeperiod_viewturns")
     * @Method("GET")
     * @Security("is_granted('CAN_ORGANIZE', downtimePeriod)")
     */
    public function viewturnsAction(DowntimePeriod $downtimePeriod, $format)
    {
        switch ($format) {
            case "excel":
                return $this->render('downtimeperiod/viewturns.xlsx.twig', array(
                    'downtimePeriod' => $downtimePeriod,
                ));
                break;
            default:
                return $this->render('downtimeperiod/viewturns.html.twig', array(
                    'downtimePeriod' => $downtimePeriod,
                ));
        }
    }

    /**
     * Finds and displays a downtimePeriod entity.
     *
     * @Route("/{id}", name="downtimeperiod_show")
     * @Method("GET")
     */
    public function showAction(DowntimePeriod $downtimePeriod)
    {
        $deleteForm = $this->createDeleteForm($downtimePeriod);

        return $this->render('downtimeperiod/show.html.twig', array(
            'downtimePeriod' => $downtimePeriod,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing downtimePeriod entity.
     *
     * @Route("/{id}/edit", name="downtimeperiod_edit")
     * @Security("is_granted('CAN_ORGANIZE', downtimePeriod)")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DowntimePeriod $downtimePeriod)
    {
        $deleteForm = $this->createDeleteForm($downtimePeriod);
        $editForm = $this->createForm('AppBundle\Form\DowntimePeriodType', $downtimePeriod);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('downtimeperiod_edit', array('id' => $downtimePeriod->getId()));
        }

        return $this->render('downtimeperiod/edit.html.twig', array(
            'downtimePeriod' => $downtimePeriod,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a downtimePeriod entity.
     *
     * @Route("/{id}", name="downtimeperiod_delete")
     * @Security("has_role('ROLE_ORGANIZER') and is_granted('CAN_ORGANIZE', downtimePeriod)") 
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DowntimePeriod $downtimePeriod)
    {
        $form = $this->createDeleteForm($downtimePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($downtimePeriod);
            $em->flush();
        }

        return $this->redirectToRoute('downtimeperiod_index');
    }

    /**
     * Creates a form to delete a downtimePeriod entity.
     *
     * @param DowntimePeriod $downtimePeriod The downtimePeriod entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DowntimePeriod $downtimePeriod)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('downtimeperiod_delete', array('id' => $downtimePeriod->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
