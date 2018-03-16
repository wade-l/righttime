<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DowntimePeriod;
use AppBundle\Entity\Member;
use AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Downtimeperiod controller.
 *
 * @Route("downtimeperiod")
 */
class DowntimePeriodController extends Controller
{
    /**
     * Lists all downtimePeriod entities.
     *
     * @Route("/", name="downtimeperiod_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $downtimePeriods = $em->getRepository('AppBundle:DowntimePeriod')->findAll();

        return $this->render('downtimeperiod/index.html.twig', array(
            'downtimePeriods' => $downtimePeriods,
        ));
    }

    /**
     * Creates a new downtimePeriod entity.
     *
     * @Route("/new", name="downtimeperiod_new")
     * #Security("has_role('ROLE_ORGANIZER')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $games = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Game')
                ->findAllByUserAndPosition($this->getUser(), 'organizer');

        $downtimePeriod = new Downtimeperiod();
        $form = $this->createForm('AppBundle\Form\DowntimePeriodType', $downtimePeriod, array(
            'games' => $games,
        ));
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
