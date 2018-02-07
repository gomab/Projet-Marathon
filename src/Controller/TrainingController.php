<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 11:42
 */

namespace App\Controller;

use App\AppAccess;
use App\Entity\Vote;
use App\Event\VoteEvent;
use App\Entity\Training;
use App\Entity\Comment;
use App\AppEvent;
use App\Event\TrainingEvent;
use App\Event\CommentEvent;
use App\Form\TrainingType;
use App\Form\CommentType;
use App\Form\VoteType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(path="/training")
 */
class TrainingController extends Controller
{
    /**
     * @Route(path="/", name="training_index")
     */
    public function index()
    {
        $trainings = $this->getDoctrine()->getManager()->getRepository(Training::class)->findAll();;

        return $this->render('Training/index.html.twig', ['trainings' => $trainings]);
    }

    /**
     * @Route(path="/show/{id}", name="training_show")
     */
    public function show(Request $request, Training $training)
    {
        $comments = $this->getDoctrine()->getManager()->getRepository(Comment::class)->findBy(['training'=> $training->getId()]);
        $votes = $this->getDoctrine()->getManager()->getRepository(Vote::class)->findBy(['training'=> $training->getId()]);

        $newComment = $this->get(Comment::class);
        $newVote = $this->get(Vote::class);

        $form = $this->createForm(CommentType::class, $newComment, ['training'=>$training]);
        $form2 = $this->createForm(VoteType::class, $newVote, ['training'=>$training]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(CommentEvent::class);
            $event->setComment($newComment);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::COMMENT_ADD, $event);

            return $this->redirectToRoute("training_show", ["id" => $training->getId()]);
        }

        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()){

            $event = $this->get(VoteEvent::class);
            $event->setVote($newVote);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::VOTE_ADD, $event);

            return $this->redirectToRoute("training_show", ["id" => $training->getId()]);
        }

        return $this->render('Training/show.html.twig', ['training' => $training, 'votes' => $votes, 'comments' => $comments, "form" => $form->createView(), "form2" => $form2->createView()]);
    }

    /**
     * @Route(path="/new", name="training_new")
     */
    public function newAction(Request $request)
    {
        $training = $this->get(Training::class);

        $form = $this->createForm(TrainingType::class, $training);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(TrainingEvent::class);
            $event->setTraining($training);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::TRAINING_ADD, $event);

            return $this->redirectToRoute("training_index");
        }

        return $this->render("Training/new.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route(path="/edit/{id}", name="training_edit")
     */
    public function editAction(Request $request, Training $training)
    {
        $form = $this->createForm(TrainingType::class, $training);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(TrainingEvent::class);
            $event->setTraining($training);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::TRAINING_EDIT, $event);

            return $this->redirectToRoute("training_show", ["id" => $training->getId()]);
        }

        return $this->render("Training/edit.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route(path="/{id}/delete", name="training_delete")
     */
    public function deleteAction(Training $training)
    {

        $event = $this->get(TrainingEvent::class);
        $event->setTraining($training);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::TRAINING_DELETE, $event);

        return $this->redirectToRoute("training_index");

    }
}