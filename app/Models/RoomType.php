<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoomType extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'roomType',
        'name',
        'beds',
        'price',
        'area'
    ];

    public function services()
    {
        return $this->belongsToMany(RoomService::class,
            'rooms_services',
            'room_type_id',
            'room_service_id'
        );
    }


}
