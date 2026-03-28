<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nutrition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'nutrition';

    protected $fillable = [
        'name',
        'code',
        'hotel_id',
        'price',
        'is_base',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
