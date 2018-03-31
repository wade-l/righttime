<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Character controller.
 *
 * @Route("character")
 */
class CharacterController extends Controller
{
    /**
     * Lists all character entities.
     *
     * @Route("/", name="character_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sac = $this->get('security.authorization_checker');

        if ( $sac->isGranted('ROLE_ADMIN') ) {
            $characters = $em->getRepository('AppBundle:Character')->findAll();
        } else {
            $characters = $this->getUser()->getCharacters();
        }



        return $this->render('character/index.html.twig', array(
            'characters' => $characters,
        ));
    }

    /**
     * Creates a new character entity.
     *
     * @Route("/new", name="character_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $character = new Character();
        $player = $this->getUser();

        if ( $player != null ) {
            $character->setPlayer($this->getUser());
            $games = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Game')
                    ->findAllByUser($player);
        }     

        $form = $this->createForm('AppBundle\Form\CharacterType', $character, array(
            'games' => $games,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($character);
            $em->flush();

            return $this->redirectToRoute('character_show', array('id' => $character->getId()));
        }

        return $this->render('character/new.html.twig', array(
            'character' => $character,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a character entity.
     *
     * @Route("/{id}", name="character_show")
     * @Security("is_granted('CAN_EDIT', character)")
     * @Method("GET")
     */
    public function showAction(Character $character)
    {
        $deleteForm = $this->createDeleteForm($character);

        return $this->render('character/show.html.twig', array(
            'character' => $character,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing character entity.
     *
     * @Route("/{id}/edit", name="character_edit")
     * @Security("is_granted('CAN_EDIT', character)")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Character $character)
    {
        $deleteForm = $this->createDeleteForm($character);
        $editForm = $this->createForm('AppBundle\Form\CharacterType', $character);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('character_edit', array('id' => $character->getId()));
        }

        return $this->render('character/edit.html.twig', array(
            'character' => $character,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a character entity.
     *
     * @Route("/{id}", name="character_delete")
     * @Security("is_granted('CAN_EDIT', character)")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Character $character)
    {
        $form = $this->createDeleteForm($character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($character);
            $em->flush();
        }

        return $this->redirectToRoute('character_index');
    }

    /**
     * Creates a form to delete a character entity.
     *
     * @param Character $character The character entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Character $character)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('character_delete', array('id' => $character->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
