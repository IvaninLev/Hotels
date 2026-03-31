<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => ['required', 'exists:tours,id'],
            'hotel_id' => ['required', 'exists:hotels,id'],
            'tour_departure_id' => ['nullable', 'exists:tour_departures,id'],
            'room_type_id' => ['nullable', 'exists:room_types,id'],
            'nutrition_id' => ['nullable', 'exists:nutrition,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'nights' => ['nullable', 'integer', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
