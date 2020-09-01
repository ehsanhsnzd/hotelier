<?php


namespace Hotel\app\Http\Controllers;


use Hotel\app\Http\Requests\Reserve\SetReserveRequest;
use Hotel\app\Services\ReserveService;

class ReserveController extends AbstractController
{

    /**
    * @var mixed|null
    */
    protected $service;

    public function __construct($service = NULL){
        $this->service= $service ?? new ReserveService();
    }

    public function book(SetReserveRequest $request)
    {
        try{
            return $this->setMetaData($this->service->set($request->getData()))->successResponse();
        }catch (\Exception $exception){
            return $this->handleException($request,$exception);
        }
    }
}
