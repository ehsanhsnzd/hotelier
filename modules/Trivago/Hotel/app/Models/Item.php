<?php


namespace Hotel\app\Models;


class Item extends BaseModel
{
    protected $fillable= ['name','rating','category','image','reputation','price','reputationBadge','availability'];


    /** hotel location
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class,'item_id','id');
    }
}
