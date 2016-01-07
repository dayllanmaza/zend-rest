<?php
namespace App\Service;

use App\Entity\Restaurant;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestaurantService implements RestaurantServiceInterface, ServiceLocatorAwareInterface
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
			->select('Restaurant', 'Reservation')
			->from('\App\Entity\Restaurant', 'Restaurant')
			->leftJoin('Restaurant.reservations', 'Reservation');
		
		$restaurants = $qb->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		return $restaurants;
	}

	public function create($data)
	{
		$em = $this->getEntityManager();

		$restaurant = new Restaurant();
		$restaurant->setName($data['name']);
		
		$em->persist($restaurant);
		$em->flush();

		return $restaurant;
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