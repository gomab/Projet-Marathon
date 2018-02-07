<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 12:02
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\User;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserSubscriber implements EventSubscriberInterface
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
            AppEvent::ADMIN_BLOCK => array('block', 0),
            AppEvent::ADMIN_DEBLOCK => array('deblock', 0),
            AppEvent::ADMIN_DELETE => array('delete', 0),
        ];
    }

    public function block(UserEvent $userEvent)
    {
        $user= $userEvent->getUser();
        $user->setBloquer(true);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function deblock(UserEvent $userEvent)
    {
        $user= $userEvent->getUser();
        $user->setBloquer(false);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function delete(UserEvent $userEvent)
    {
        $this->em->remove($userEvent->getUser());
        $this->em->flush();
    }
}