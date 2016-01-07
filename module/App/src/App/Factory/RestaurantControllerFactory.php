<?php

namespace App\Factory;

use App\Controller\RestaurantController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestaurantControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = $serviceLocator->getServiceLocator();
		$restaurantService = $sl->get('App\Service\RestaurantServiceInterface');

		return new RestaurantController($restaurantService);
	}
}