<?php


namespace Hotel\app\Services;


use Hotel\app\Repositories\HotelRepository;

class HotelService
{
    /**
    * @var mixed|null
    */
    private $repo;

    public function __construct($repository = NULL){
        $this->repo = $repository ?? new HotelRepository();
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function get($request)
    {
        return $this->repo->find($request['id']);
    }

    public function set($request)
    {
        return $this->repo->create($request)->toArray();
    }

    public function update($request)
    {
        return $this->repo->update($request);
    }
}
