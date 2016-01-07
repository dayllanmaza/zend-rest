<?php
namespace App\Service;

use App\Exception\ReservationException;
use App\Entity\Reservation;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReservationService implements ReservationServiceInterface, ServiceLocatorAwareInterface
{
	protected $em;

	public function getEntityManager()
	{
		if ($this->em == null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

	public function findAll()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb
			->select('Reservation', 'Restaurant')
			->from('\App\Entity\Reservation', 'Reservation')
			->leftJoin('Reservation.restaurant', 'Restaurant');
		
		$reservations = $qb->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		return $reservations;
	}

	public function findOneById($id)
	{
		$em = $this->getEntityManager();
		$reservation = $em->find('\App\Entity\Reservation', $id);

		return $reservation;
	}

	public function create($data)
	{
		$em = $this->getEntityManager();

		$restaurant = $em->find('\App\Entity\Restaurant', (int) $data['restaurantId']);
	
		$reservation = new Reservation();
		$reservation->setRestaurant($restaurant);
		$reservation->setNumberOfPeople($data['numberOfPeople']);
		$reservation->setReservationDate(new \DateTime($data['reservationDate']));

		$em->persist($reservation);
		$em->flush();

		return $reservation;
	}

	public function update($id, $data)
	{
		$em = $this->getEntityManager();
		
		$reservation = $em->find('\App\Entity\Reservation', (int) $id);
		if (!$reservation) {
			throw new ReservationException('Reservation Not Found');
		}

		if ($data['restaurantId']) {
			$restaurant = $em->find('\App\Entity\Restaurant', $data['restaurantId']);
			$reservation->setRestaurant($restaurant);
		}

		if ($data['reservationDate']) {
			$reservationDate = new \DateTime($data['reservationDate']);
			$reservation->setReservationDate($reservationDate);
		}

		if ($data['numberOfPeople']) {
			$reservation->setNumberOfPeople($data['numberOfPeople']);
		}

		$em->persist($reservation);
		$em->flush();
		
		return $reservation;
	}

	public function delete($id)
	{
		$em = $this->getEntityManager();
		$reservation = $em->find('\App\Entity\Reservation', (int) $id);

		if (!$reservation) {
			throw new ReservationException('Reservation not found');
		}

		$em->remove($reservation);
		$em->flush();

		return true;
	}

	/******************************************************
	** NOTE: This can probably be avoided 
	** by using a factory in service_manager config ?
	********************************************************/
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) 
	{
		$this->serviceLocator = $serviceLocator;
	}

	public function getServiceLocator() 
	{
		return $this->serviceLocator;
	}
}