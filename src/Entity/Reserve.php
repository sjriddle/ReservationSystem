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
    private $first_name;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $last_name;

    /**
     * @ORM\Column(type="date")
     */
    private $res_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $res_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $admin_id;



    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->res_date;
    }

    public function getAdminId() {
        return $this->admin_id;
    }

    public function setAdminId($admin_id) {
        $this->admin_id = $admin_id;
    }

    public function setDate($res_date) {
        $this->res_date = $res_date;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getTime() {
        return $this->res_time;
    }

    public function setTime($res_time) {
        $this->res_time = $res_time;
    }
}
