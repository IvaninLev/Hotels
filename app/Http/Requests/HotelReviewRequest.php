<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hotel_id' => ['required', 'exists:hotels,id'],

            'person_name' => ['required', 'string', 'max:255'],
            'person_second_name' => ['required', 'string', 'max:255'],

            'from_city_id' => ['nullable', 'integer', 'exists:cities,id'],

            'main_text' => ['required', 'string', 'max:2000'],

            'review_date' => ['required', 'date'],

            'rating_for_food' => ['required', 'integer', 'between:1,5'],
            'rating_for_room' => ['required', 'integer', 'between:1,5'],
            'rating_price_quality' => ['required', 'integer', 'between:1,5'],
            'rating_for_beach' => ['required', 'integer', 'between:1,5'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
