<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 18:25
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\Article;
use App\Entity\Media;
use App\Event\MediaEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MediaSubscriber implements EventSubscriberInterface
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
            AppEvent::MEDIA_ADD => array('add', 0),
            AppEvent::MEDIA_EDIT => array('persist', 0),
            AppEvent::MEDIA_DELETE => array('remove', 0),
        ];
    }

    public function add(MediaEvent $mediaEvent)
    {
        $this->persist($mediaEvent);
    }

    public function persist(MediaEvent $mediaEvent)
    {
        $this->em->persist($mediaEvent->getMedia());
        $this->em->flush();
    }

    public function remove(ArticleEvent $articleEvent)
    {
        $article = $articleEvent->getArticle();
        $media = $article->getMedia();
        $this->em->remove($media);
        $this->em->flush();
    }
}