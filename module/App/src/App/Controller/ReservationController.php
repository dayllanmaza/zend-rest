<?php
namespace App\Controller;

use App\Exception\ReservationException;
use App\Service\ReservationServiceInterface;
use Zend\View\Model\JsonModel;

class ReservationController extends BaseController
{
	protected $reservationService;

	public function __construct(ReservationServiceInterface $reservationService) 
	{
		$this->reservationService = $reservationService;
	}

	public function getlist()
	{
		$reservations = $this->reservationService->findAll();
		return new JsonModel(array('data' => $reservations));
	}

	public function get($id)
	{
		$reservation = $this->reservationService->findOneById((int) $id);

		if (!$reservation) {
			$response = $this->getResponse();
			$response->setStatusCode(404);

			throw new ReservationException('Reservation not found');
		}

		// TODO: find a way for JsonModel to handle entities with protected properties
		$data = array(
			'id' => $reservation->getId(),
			'restaurant' => $reservation->getRestaurant()->getName(),
			'numberOfPeople' => $reservation->getNumberOfPeople(),
			'reservationdate' => $reservation->getReservationDate(),
		);

		return new JsonModel(array('data' => $data));
	}

	public function create($data)
	{
		$reservation = $this->reservationService->create($data);

		// TODO: find a way for JsonModel to handle entities with protected properties
		$data = array(
			'id' => $reservation->getId(),
			'restaurant' => $reservation->getRestaurant()->getName(),
			'numberOfPeople' => $reservation->getNumberOfPeople(),
			'reservationdate' => $reservation->getReservationDate(),
		);

		$response = $this->getResponse();
		$response->setStatusCode(201);

		return new JsonModel(array('data' => $data));
	}

	public function patch($id, $data)
	{
		$reservation = $this->reservationService->update($id, $data);

		// TODO: find a way for JsonModel to handle entities with protected properties
		$data = array(
			'id' => $reservation->getId(),
			'restaurant' => $reservation->getRestaurant()->getName(),
			'numberOfPeople' => $reservation->getNumberOfPeople(),
			'reservationdate' => $reservation->getReservationDate(),
		);

		return new JsonModel(array('data' => $data));
	}

	public function delete($id)
	{
		$this->reservationService->delete($id);
		return new JsonModel(array('data' => array('success' => true)));
	}
}