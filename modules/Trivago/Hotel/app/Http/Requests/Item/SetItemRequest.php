<?php

namespace Hotel\app\Http\Requests\Item;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetItemRequest extends FormRequest
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
            'name' => ['required','string', function ($attribute, $value, $fail) {
                    foreach (["free","Offer","Book","Website"] as $word)
                        if (stripos($value, $word) !== false)
                            $fail($attribute . ' contain invalid word.');}],
            'rating' => 'required|numeric|between:0,5',
            'category' => 'required|string|exists:item_categories,name',
            'image' => 'required|string|url',
            'reputation' => 'required|numeric|between:0,1000',
            'price' => 'required|numeric',
            'availability' => 'required|numeric',
            'location.city' => 'required|string',
            'location.state' => 'required|string',
            'location.country' => 'required|string',
            'location.zip_code' => 'required|numeric|digits:5',
            'location.address' => 'required|string',
        ];
    }


    public function getData()
    {
        return $this->only('name','rating','category','image','reputation','price','availability','location');
    }
}
