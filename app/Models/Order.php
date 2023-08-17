<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function services () {
        return $this->belongsToMany(Service::class)->withPivot('quantity', 'price');
    }

    public function groups () {
        return $this->belongsToMany(Group::class)->withPivot('quantity');
    }

}
