<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 11:42
 */

namespace App\Controller;

use App\AppAccess;
use App\Entity\Comment;
use App\AppEvent;
use App\Event\CommentEvent;
use App\Form\CommentType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(path="/comment")
 */
class CommentController extends Controller
{

    /**
     * @Route(path="/new", name="comment_new")
     */
    public function newAction(Request $request)
    {
        $comment = $this->get(Comment::class);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $event = $this->get(CommentEvent::class);
            $event->setComment($comment);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::COMMENT_ADD, $event);
            return $this->redirectToRoute("welcome");
        }
        return $this->render("Comment/new.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route(path="/{id}/delete", name="comment_delete")
     */
    public function deleteAction(Comment $comment)
    {
        $event = $this->get(CommentEvent::class);
        $event->setComment($comment);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::COMMENT_DELETE, $event);
        return $this->redirectToRoute("admin");
    }
}