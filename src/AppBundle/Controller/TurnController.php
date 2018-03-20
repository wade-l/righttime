<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Turn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
     * Creates a new turn entity.
     *
     * @Route("/new", name="turn_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $turn = new Turn();
        $form = $this->createForm('AppBundle\Form\TurnType', $turn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turn);
            $em->flush();

            return $this->redirectToRoute('turn_show', array('id' => $turn->getId()));
        }

        return $this->render('turn/new.html.twig', array(
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
     * Displays a form to edit an existing turn entity.
     *
     * @Route("/{id}/edit", name="turn_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Turn $turn)
    {
        $deleteForm = $this->createDeleteForm($turn);
        $editForm = $this->createForm('AppBundle\Form\TurnType', $turn);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('turn_edit', array('id' => $turn->getId()));
        }

        return $this->render('turn/edit.html.twig', array(
            'turn' => $turn,
            'edit_form' => $editForm->createView(),
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
