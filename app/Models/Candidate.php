<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    // use SoftDeletes;
    protected $fillable=[
        'name',
        'email',
        'phone',
        'address',
        'city',
        'CNIC',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
