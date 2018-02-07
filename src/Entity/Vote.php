<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="votes")
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;
    /**
     * @var Training
     * @ORM\ManyToOne(targetEntity="App\Entity\Training")
     */
    private $training;
    /**
     * @var int
     * @ORM\Column(columnDefinition="TINYINT(4)")
     */
    private $value;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return Training
     */
    public function getTraining(){
        return $this->training;
    }

    /**
     * @param Training $training
     */
    public function setTraining($training) {
        $this->training = $training;
    }

    /**
     * @return int
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value) {
        $this->value = $value;
    }
}
