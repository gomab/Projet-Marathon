<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 12:02
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\Comment;
use App\Event\CommentEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommentSubscriber implements EventSubscriberInterface
{

    private $em;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->em = $entityManager;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::COMMENT_ADD => array('add', 0),
            AppEvent::COMMENT_DELETE => array('remove', 0),
        ];
    }

    public function add(CommentEvent $commentEvent)
    {
        $this->persist($commentEvent);
    }

    public function persist(CommentEvent $commentEvent)
    {
        $this->em->persist($commentEvent->getComment());
        $this->em->flush();
    }

    public function remove(CommentEvent $commentEvent)
    {
        $this->em->remove($commentEvent->getComment());
        $this->em->flush();
    }
}