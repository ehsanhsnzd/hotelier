<?php


namespace Hotel\app\Http\Controllers;


use Hotel\app\Http\Requests\Item\DeleteItemRequest;
use Hotel\app\Http\Requests\Item\GetItemRequest;
use Hotel\app\Http\Requests\Item\SetItemRequest;
use Hotel\app\Http\Requests\Item\UpdateItemRequest;
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

    public function all(Request $request)
    {
        try{
            return $this->setMetaData($this->service->all())->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function get(GetItemRequest $request)
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
            return $this->setMetaData($this->service->set($request->getData()))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function edit(UpdateItemRequest $request)
    {
        try{
            return $this->setMetaData($this->service->edit($request->getData()))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }

    public function delete(DeleteItemRequest $request)
    {
        try{
            $this->service->delete($request);
            return $this->setMetaData([])->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }
}
