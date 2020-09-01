<?php


namespace Hotel\app\Services;


use Carbon\Carbon;
use Hotel\app\Repositories\ItemRepository;
use Hotel\app\Repositories\ReserveRepository;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class ReserveService
{
    /**
    * @var mixed|null
    */
    private $repo;
    private $itemRepo;

    public function __construct($repository = NULL){
        $this->repo = $repository ?? new ReserveRepository();
        $this->itemRepo = $repository ?? new ItemRepository();
    }

    public function all()
    {
        return $this->repo->all()->toArray();
    }

    public function get($request)
    {
        return $this->repo->find($request['id'])->toArray();
    }

    public function set($request)
    {
        $request['departure_date'] = $this->departure($request['departure_date']);

        $count = $this->repo
            ->whereBetween('departure_date', [$request['arrival_date'], $request['departure_date']])
            ->orWhereBetween('arrival_date', [$request['arrival_date'], $request['departure_date']])
            ->count();

        if ($this->itemRepo->find($request['item_id'])
            ->availability<=$count)
            throw new AccessDeniedException('there is no accommodation');

        return $this->repo->create($request)->toArray();
    }

    public function update($request)
    {
        return $this->repo->update($request->id,$request->all());
    }

    public function departure($departure)
    {
        return (new Carbon($departure))
            ->subDays(1)->toDateString();
    }
}
