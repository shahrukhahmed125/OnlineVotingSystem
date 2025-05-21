<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliticalParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'symbol', // image or icon
        'leader_name',
        'founded_year',
        'head_office',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
    
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
