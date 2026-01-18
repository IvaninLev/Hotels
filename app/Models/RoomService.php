<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class RoomService extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $fillable = ['name'];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'rooms_services', 'room_service_id', 'room_type_id');
    }
}
