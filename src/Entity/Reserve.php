<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReserveRepository")
 */
class Reserve
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;


    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }
}
