<?php


namespace Hotel\app\Services;


use Hotel\app\Repositories\ItemRepository;

class ItemService
{
    /**
    * @var mixed|null
    */
    private $repo;

    public function __construct($repository = NULL){
        $this->repo = $repository ?? new ItemRepository();
    }

    public function all()
    {
        return $this->repo->all()->toArray();
    }

    public function get($request)
    {
        return $this->repo->fetch($request['id'],['location'])
            ->toArray();
    }

    public function set($request)
    {
        $item = $this->repo->create($request);
        $item->location()->create($request['location']);

        return $item->load('location')
            ->toArray();
    }

    /** update item
     * @param $request
     * @return mixed|void
     */
    public function edit($request)
    {
        $this->repo->update($request['id'],$request);
        $this->repo->find($request['id'])
            ->location()->first()->update($request['location']);

        return $this->repo->fetch($request['id'],['location'])->toArray();
    }

    /** delete item
     * @param $request
     * @return mixed|void
     */
    public function delete($request)
    {
        return $this->repo->delete($request['id']);
    }

}
