<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 12:00
 */

namespace App\Event;

use App\Entity\Training;
use App\Entity\Media;
use Symfony\Component\EventDispatcher\Event;

class TrainingEvent extends Event
{
    protected $training;
    protected $media;

    public function getTraining()
    {
        return $this->training;
    }

    public function setTraining(Training $training)
    {
        $this->training = $training;
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