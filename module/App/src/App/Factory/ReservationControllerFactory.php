<?php

namespace App\Factory;

use App\Controller\ReservationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReservationControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = $serviceLocator->getServiceLocator();
		$reservationService = $sl->get('App\Service\ReservationServiceInterface');

		return new ReservationController($reservationService);
	}
}