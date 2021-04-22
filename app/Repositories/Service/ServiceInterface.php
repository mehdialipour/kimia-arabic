<?php 

namespace App\Repositories\Service;

interface ServiceInterface {

	public function all();

	public function insurances();

	public function create($name, $tariffs);

	public function edit($id);

	public function returnTariffs($id);

	public function update($id, $name, $tariffs);

	public function activate($id);

	public function deactivate($id);

}