<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 12:02
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\Training;
use App\Event\TrainingEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TrainingSubscriber implements EventSubscriberInterface
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
            AppEvent::TRAINING_ADD => array('add', 0),
            AppEvent::TRAINING_EDIT => array('add', 0),
            AppEvent::TRAINING_DELETE => array('remove', 0),
        ];
    }

    public function add(TrainingEvent $trainingEvent)
    {
        $this->persist($trainingEvent);
    }

    public function persist(TrainingEvent $trainingEvent)
    {
        $this->em->persist($trainingEvent->getTraining());
        $this->em->flush();
    }

    public function remove(TrainingEvent $trainingEvent)
    {
        $this->em->remove($trainingEvent->getTraining());
        $this->em->flush();
    }
}