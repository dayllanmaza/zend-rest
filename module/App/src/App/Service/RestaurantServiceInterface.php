<?php
namespace App\Service;

interface RestaurantServiceInterface
{
	public function findAll();
	public function create($data);
}