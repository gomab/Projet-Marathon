<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 18:09
 */

namespace App\Event;

use App\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class MediaEvent extends Event
{
    protected $media;

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia($media)
    {
        $this->media = $media;
    }
}