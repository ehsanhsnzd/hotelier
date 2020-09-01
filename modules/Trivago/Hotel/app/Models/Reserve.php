<?php


namespace Hotel\app\Models;


class Reserve extends BaseModel
{
    protected $fillable= ['item_id','arrival_date','departure_date'];

    protected $table='item_reserve';

}
