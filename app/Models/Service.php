<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function imageUrl (): string {
        return Storage::url($this->image);
    }

}
