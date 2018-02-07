<?php
/**
 * Created by PhpStorm.
 * User: thomasdebacker
 * Date: 21/12/2017
 * Time: 08:28
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\Vote;
use App\Event\VoteEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VoteSubscriber implements EventSubscriberInterface
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
            AppEvent::VOTE_ADD => array('add', 0),
            AppEvent::VOTE_DELETE => array('remove', 0),
        ];
    }

    public function add(VoteEvent $voteEvent)
    {
        $this->persist($voteEvent);
    }

    public function persist(voteEvent $voteEvent)
    {
        $this->em->persist($voteEvent->getVote());
        $this->em->flush();
    }

    public function remove(VoteEvent $voteEvent)
    {
        $this->em->remove($voteEvent->getVote());
        $this->em->flush();
    }
}