<?php


namespace Hotel\app\Repositories;


use Hotel\app\Models\Reserve;
use Illuminate\Database\Eloquent\Collection;

class ReserveRepository implements Repository
{

    /**
    * @var mixed|null
    */
    private $model;

    public function __construct(){
        $this->model = new Reserve();
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
    }

    public function fetch(string $id, array $relations): Collection
    {
        // TODO: Implement fetch() method.
    }

    public function model(int $id)
    {
        // TODO: Implement model() method.
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function create(array $params)
    {
        return $this->model->create($params);
    }

    public function update(int $id, array $params)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function where(array $params)
    {
        // TODO: Implement where() method.
    }

    public function whereBetween($field,$param)
    {
        return $this->model->whereBetween($field,$param);
    }
}
