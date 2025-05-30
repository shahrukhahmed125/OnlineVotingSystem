<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable =[
        'user_id',
        'candidate_id',
        'election_id',
        'voted_at',
        'assembly_id',
        'has_voted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    public function election()
    {
        return $this->belongsTo(Election::class);
    }
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}
