<?php
namespace App\Controller;

use App\Service\RestaurantServiceInterface;
use Zend\View\Model\JsonModel;

class RestaurantController extends BaseController
{
	protected $restaurantService;

	public function __construct(RestaurantServiceInterface $restaurantService) 
	{
		$this->restaurantService = $restaurantService;
	}

	public function getlist()
	{
		$restaurants = $this->restaurantService->findAll();
		return new JsonModel(array('data' => $restaurants));
	}

	public function create($data)
	{
		$restaurant = $this->restaurantService->create($data);

		// TODO: find a way for JsonModel to handle entities with protected properties
		$data = array(
			'id' => $restaurant->getId(),
			'name' => $restaurant->getName(),
		);

		$response = $this->getResponse();
		$response->setStatusCode(201);

		return new JsonModel(array('data' => $data));
	}

}