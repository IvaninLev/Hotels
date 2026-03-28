<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'description' => ['string', 'required'],
            'country' => ['required', 'exists:countries,id'],
            'city' => ['required', 'exists:cities,id'],
            'images' => ['required', 'array'],
            'rating' => [ 'required','max:5','min:1'],
            'price' => ['required', 'decimal:8,2', 'min:1'],
            'nutrition' => ['required', 'string'],
            'hotel_features' => ['required', 'array'],
            'roomTypes' => ['required','json', 'min:1'],
            'roomTypes.*' => ['array'],
            'roomTypes.*.room_type_id' => ['required', 'integer', 'exists:room_types,id'],
            'roomTypes.*.price' => ['required', 'decimal'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
