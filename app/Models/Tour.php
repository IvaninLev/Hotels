<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tour extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $table = 'tours';

    protected $fillable = [
        'name',
        'price',
        'hotel_id',
        'airport_id',
        'description',
        'active_from',
        'active_to',
    ];

    protected $casts = [
        'price' => 'decimal'
    ];


    public function airport():BelongsTo
    {
        return $this->belongsTo(Airport::class, 'airport_id', 'id');
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
}
