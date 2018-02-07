<?php
/**
 * Created by PhpStorm.
 * User: thomasdebacker
 * Date: 21/12/2017
 * Time: 08:27
 */

namespace App\Event;

use App\Entity\Vote;
use Symfony\Component\EventDispatcher\Event;

class VoteEvent extends Event
{
    protected $vote;

    public function getVote()
    {
        return $this->vote;
    }

    public function setVote($vote)
    {
        $this->vote = $vote;
    }
}