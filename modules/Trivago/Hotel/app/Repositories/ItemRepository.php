<?php


namespace Hotel\app\Repositories;


use Hotel\app\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository implements Repository
{

    /**
    * @var mixed|null
    */
    private $model;

    public function __construct(){
        $this->model= new Item();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function fetch(string $id, array $relations,$field = null):Collection
    {
        return $this->where([$field ?? 'id'=>$id])
            ->with($relations)
            ->get();
    }

    public function model(int $id)
    {
        return $this->model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $params)
    {
        return $this->model->create($params);
    }

    public function update(int $id, array $params)
    {
        return $this->model->find($id)->update($params);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function where(array $params)
    {
        return $this->model->where($params);
    }
}
