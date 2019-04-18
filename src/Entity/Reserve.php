<?php

/**
 * Doctrine is an ORM for Symfony. This model is essentailly PHP code that
 * is used to create database schema and tables. Doctrine can also be used
 * to migrate/write data to the DB from the PHP application.
 *
 * Documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html
 */

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
