<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 12:02
 */

namespace App\EventListener;

use App\AppEvent;
use App\Entity\Article;
use App\Event\ArticleEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ArticleSubscriber implements EventSubscriberInterface
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
            AppEvent::ARTICLE_ADD => array('add', 0),
            AppEvent::ARTICLE_EDIT => array('persist', 0),
            AppEvent::ARTICLE_DELETE => array('remove', 0),
        ];
    }

    public function add(ArticleEvent $articleEvent)
    {
        $this->persist($articleEvent);
    }

    public function persist(ArticleEvent $articleEvent)
    {
        if($articleEvent->getMedia() != null){
            $article = $articleEvent->getArticle();
            $media = $articleEvent->getMedia();
            $article->setMedia($media);

            $this->em->persist($article);
            $this->em->persist($media);
        } else {
            $article = $articleEvent->getArticle();
            $article->setMedia(null);

            $this->em->persist($article);
        }
        $this->em->flush();
    }

    public function remove(ArticleEvent $articleEvent)
    {
        $this->em->remove($articleEvent->getArticle());
        if($articleEvent->getMedia() != null){
            $this->em->remove($articleEvent->getMedia());
        }
        $this->em->flush();
    }
}