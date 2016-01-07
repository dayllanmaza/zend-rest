<?php
namespace App\Service;

interface ReservationServiceInterface
{
	public function findAll();
	public function findOneById($id);
	public function create($data);
	public function update($id, $data);
	public function delete($id);
}