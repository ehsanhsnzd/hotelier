<?php


namespace Hotel\app\Http\Controllers;


use Hotel\app\Http\Requests\Item\SetItemRequest;
use Hotel\app\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends BaseController
{

    /**
    * @var mixed|null
    */
    protected $service;

    public function __construct($service = NULL){
        $this->service= $service ?? new ItemService();
    }

    public function get(Request $request)
    {
        try{
            return $this->setMetaData($this->service->get($request))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function set(SetItemRequest $request)
    {
        try{
            return $this->setMetaData($this->service->set($request->all()))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function edit(Request $request)
    {
        try{
            return $this->setMetaData($this->service->edit($request->all()))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function delete(Request $request)
    {
        try{
            $this->service->delete($request);
            return $this->setMetaData([])->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }
}
