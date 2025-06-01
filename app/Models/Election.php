<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function generateElectionId()
    {
        $this->election_id = 'ELEC-' . strtoupper(uniqid());
        $this->save();
    }
    
}
