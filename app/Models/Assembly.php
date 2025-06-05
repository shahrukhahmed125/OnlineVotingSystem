<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'name', 'province', 'district', 'description',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'constituency_id');
    }

    public function naUsers()
    {
        return $this->hasMany(User::class, 'na_constituency_id');
    }

    public function paUsers()
    {
        return $this->hasMany(User::class, 'pa_constituency_id');
    }

    public function elections()
    {
        return $this->hasMany(Election::class, 'assembly_id');
    }
}
