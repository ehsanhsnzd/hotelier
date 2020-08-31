<?php


namespace Hotel\app\Http\Controllers;


use Hotel\app\Services\HotelService;

class HotelController extends AbstractController
{

    /**
    * @var mixed|null
    */
    protected $service;

    public function __construct($service = NULL){
        $this->service= $service ?? new HotelService();
    }

}
