<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'tour_reviews';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'main_text',
        'avatar',
        'was_in_hotel',
        'person_from',
        'flight_to',
        'rating',
        'flight_date',
    ];
    protected $casts = [
        'avatar' => 'array',
    ];
}
