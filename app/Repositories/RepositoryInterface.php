<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function findById($id);
    public function findFirst();
    public function getAll();
    public function paginate($perPage = 15);
}
