<?php

namespace App\Controller;

use App\AppAccess;
use App\Entity\Article;
use App\Entity\Training;
use App\Entity\User;
use App\Entity\Comment;

use App\AppEvent;
use App\Event\UserEvent;
use App\Form\AdminType;
use App\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAll();
        $trainings = $this->getDoctrine()->getManager()->getRepository(Training::class)->findAll();
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $comments = $this->getDoctrine()->getManager()->getRepository(Comment::class)->findAll();
        return $this->render('admin/index.html.twig', ['articles' => $articles, 'trainings' => $trainings, 'users' => $users, 'comments' => $comments]);
    }

    /**
     * @Route(path="/admin/delete/{id}/", name="admin_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
        $event = $this->get(UserEvent::class);
        $event->setUser($user);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::ADMIN_DELETE, $event);

        return $this->redirectToRoute("admin");
    }

    /**
     * @Route(path="/admin/block/{id}/", name="admin_block")
     */
    public function editBlockAction(Request $request, User $user)
    {
        $event = $this->get(UserEvent::class);
        $event->setUser($user);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::ADMIN_BLOCK, $event);

        return $this->redirectToRoute("admin");
    }

    /**
     * @Route(path="/admin/deblock/{id}/", name="admin_deblock")
     */
    public function editDeblockAction(Request $request, User $user)
    {
        $event = $this->get(UserEvent::class);
        $event->setUser($user);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::ADMIN_DEBLOCK, $event);

        return $this->redirectToRoute("admin");
    }
}
