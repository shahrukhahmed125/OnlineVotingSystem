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
        // 'symbol', // image or icon
        'leader_name',
        'founded_at',
        'head_office',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
