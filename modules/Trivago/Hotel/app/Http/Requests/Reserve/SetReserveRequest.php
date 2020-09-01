<?php

namespace Hotel\app\Http\Requests\Reserve;



use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_id' =>        'required',
            "arrival_date"       =>  "nullable|date|after_or_equal:".Carbon::now()->format("Y-m-d"),
            "departure_date"     =>  "nullable|date|after_or_equal:arrival_date",

        ];
    }


    public function getData()
    {
        return $this->only('item_id','arrival_date','departure_date');
    }
}
