<?php

namespace App\Repositories\Insurance;

interface InsuranceInterface
{
    public function all();

    public function create($name);

    public function edit($id);

    public function update($id, $name);

    public function activate($id);

    public function deactivate($id);
}
