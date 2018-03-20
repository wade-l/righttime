<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Act;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Act controller.
 *
 * @Route("act")
 */
class ActController extends Controller
{
    /**
     * Lists all act entities.
     *
     * @Route("/", name="act_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $acts = $em->getRepository('AppBundle:Act')->findAll();

        return $this->render('act/index.html.twig', array(
            'acts' => $acts,
        ));
    }

    /**
     * Creates a new act entity.
     *
     * @Route("/new", name="act_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $act = new Act();
        $form = $this->createForm('AppBundle\Form\ActType', $act);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($act);
            $em->flush();

            return $this->redirectToRoute('act_show', array('id' => $act->getId()));
        }

        return $this->render('act/new.html.twig', array(
            'act' => $act,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a act entity.
     *
     * @Route("/{id}", name="act_show")
     * @Method("GET")
     */
    public function showAction(Act $act)
    {
        $deleteForm = $this->createDeleteForm($act);

        return $this->render('act/show.html.twig', array(
            'act' => $act,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing act entity.
     *
     * @Route("/{id}/edit", name="act_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Act $act)
    {
        $deleteForm = $this->createDeleteForm($act);
        $editForm = $this->createForm('AppBundle\Form\ActType', $act);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('act_edit', array('id' => $act->getId()));
        }

        return $this->render('act/edit.html.twig', array(
            'act' => $act,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a act entity.
     *
     * @Route("/{id}", name="act_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Act $act)
    {
        $form = $this->createDeleteForm($act);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($act);
            $em->flush();
        }

        return $this->redirectToRoute('act_index');
    }

    /**
     * Creates a form to delete a act entity.
     *
     * @param Act $act The act entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Act $act)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('act_delete', array('id' => $act->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
