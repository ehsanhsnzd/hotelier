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


    /** reservation
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function set($request)
    {
        if($request['arrival_date']!=$request['departure_date'])
        $request['departure_date'] = $this->departure($request['departure_date']);

        $count = $this->checkAvailability($request['item_id'],$request);

        if ($this->itemRepo->find($request['item_id'])
            ->availability<=$count)
            throw new AccessDeniedException('there is no accommodation');

        $reserve =  $this->repo->create($request)->toArray();

        $reserve['departure_date'] = (new Carbon($reserve['departure_date']))->addDay()->toDateString();
        return $reserve;
    }


    public function departure($departure)
    {
        return (new Carbon($departure))
            ->subDays(1)->toDateString();
    }

    /** check availability
     * @param $itemId
     * @param $request
     * @return mixed
     */
    public function checkAvailability($itemId,$request)
    {
       return $this->repo
            ->whereBetween('departure_date', [$request['arrival_date'], $request['departure_date']])
            ->orWhereBetween('arrival_date', [$request['arrival_date'], $request['departure_date']])
            ->where(['id'=>$itemId])
            ->count();
    }
}
