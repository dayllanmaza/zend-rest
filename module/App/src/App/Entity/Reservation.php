<?php

namespace App\Entity;

use App\Exception\ValidationException;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="reservation")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Reservation
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="reservations")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
	protected $restaurant;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numberOfPeople;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $reservationDate;

	public function getId()
	{
		return $this->id;
	}

	public function getRestaurant()
	{
		return $this->restaurant;
	}

	public function setRestaurant($restaurant)
	{
		$this->restaurant = $restaurant;
	}

	public function getNumberOfPeople()
	{
		return $this->numberOfPeople;
	}

	public function setNumberOfPeople($numberOfPeople)
	{
		$this->numberOfPeople = $numberOfPeople;
	}

	public function getReservationDate()
	{
		return $this->reservationDate;
	}

	public function setReservationDate($date)
	{
		$this->reservationDate = $date;
	}

	/**
	 * @ORM\PrePersist 
	 * @ORM\PreUpdate
	 */
	public function preSave()
	{
		// TODO: Do clean up data and validate stuff
		// NOTE: Validate with Annotations ??

		if (!$this->restaurant) {
			throw new ValidationException('Invalid restaurant');
		}

		if ($this->numberOfPeople < 1) {
			throw new ValidationException('Invalid number of people');
		}

		if (!$this->reservationDate) {
			throw new ValidationException('Invalid reservation date');	
		}
		
		if ($this->reservationDate < new \DateTime()) {
			throw new ValidationException("Can't book reservation in the past.");
		}		
	}
}