<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity
 */
class Restaurant
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="restaurant")
     */
    protected $reservations;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getReservations()
    {
        return $this->reservations;
    }

    public function __construct() {
    	$this->reservations = new ArrayCollection();
    }

}