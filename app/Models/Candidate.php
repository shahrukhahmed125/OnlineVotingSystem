<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'political_party_id',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function politicalParty()
    {
        return $this->belongsTo(PoliticalParty::class);
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class, 'election_candidate')
                    ->withPivot('assembly_id', 'status')
                    ->withTimestamps();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
