<?php

namespace App\Event;

use App\Entity\Article;
use App\Entity\Media;
use Symfony\Component\EventDispatcher\Event;

class ArticleEvent extends Event
{
    protected $article;
    protected $media;

    public function getArticle()
    {
        return $this->article;
    }

    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia(Media $media)
    {
        $this->media = $media;
    }
}