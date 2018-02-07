<?php

namespace App\Controller;

use App\AppAccess;
use App\Entity\Vote;
use App\AppEvent;
use App\Event\VoterEvent;
use App\Form\VoterType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(path="/voter")
 */
class VoterController extends Controller
{
    /**
     * @Route(path="/", name="voter_index")
     */
    public function index()
    {
        $voters = $this->getDoctrine()->getManager()->getRepository(Vote::class)->findAll();

        return $this->render('Voter/index.html.twig', ['articles' => $voters]);
    }

    /**
     * @Route(path="/{id}/delete", name="article_delete")
     */
    public function deleteAction(Vote $vote)
    {
        $event = $this->get(VoteEvent::class);
        $event->setVote($vote);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::VOTE_DELETE, $event);

        return $this->redirectToRoute("admin");

    }
}