<?php

namespace App\Repositories\Contracts;

/*
 * Abstract repository interface
 */
interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id, $attribute = "id");

    public function destroy($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));
}