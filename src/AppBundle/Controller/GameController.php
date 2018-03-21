<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Entity\Member;
use AppBundle\Entity\DowntimePeriod;
use AppBundle\Form\DowntimePeriodType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Game controller.
 *
 * @Route("game")
 */
class GameController extends Controller
{

    /**
     * Lists all game entities.
     *
     * @Route("/", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('AppBundle:Game')->findAll();

        return $this->render('game/index.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * Creates a new game entity.
     *
     * @Route("/new", name="game_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm('AppBundle\Form\GameType', $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Set the person creating the game as an organizer
            $user = $this->getUser();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_show', array('id' => $game->getId()));
        }

        return $this->render('game/new.html.twig', array(
            'game' => $game,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a game entity.
     *
     * @Route("/{id}", name="game_show")
     * @Method("GET")
     */
    public function showAction(Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $joinForm = $this->createJoinForm($game);

        return $this->render('game/show.html.twig', array(
            'game' => $game,
            'delete_form' => $deleteForm->createView(),
            'join_form' => $joinForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing game entity.
     *
     * @Route("/{id}/edit", name="game_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('AppBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        $somevar = "testEdit";
        dump($somevar);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a game entity.
     *
     * @Route("/{id}", name="game_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }


        return $this->redirectToRoute('game_index');
    }

    /**
     * Joins a game.
     *
     * @Route("/{id}/join", name="game_join")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function joinAction(Request $request, Game $game)
    {
              
        $form = $this->createJoinForm($game);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $member = new Member();
            $member->setUser($user);
            $member->setGame($game);
            $member->setPosition("Player");

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

        }
        return $this->redirectToRoute('game_index');
    }

    /**
     * Called via render to create Downtime periods attached to a game.
     */
    public function addDowntimePeriodForm(Game $game)
    {
        $downtimeperiod = new DowntimePeriod();
        $downtimeperiod->setGame($game);
        $downtimeperiod->setName("Downtime for " . date('F Y'));
        $form = $this->createForm('AppBundle\Form\DowntimePeriodType', $downtimeperiod);
        return $this->render('downtimeperiod/_add.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to join a game.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createJoinForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_join', array('id' => $game->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
