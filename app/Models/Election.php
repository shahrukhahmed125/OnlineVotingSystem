<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id', // Ensure this is also in your fillable if you're mass-assigning it
        'title',
        'description',
        'start_time',
        'end_time',
        'status', // Ensure this is in your fillable if you're mass-assigning it
        'is_active',
        'type'
    ];

    const TYPE_ASSEMBLY = ['general assembly', 'national assembly', 'provincial assembly'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'election_candidate')
                    ->withPivot('assembly_id', 'status')
                    ->withTimestamps();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public static function generateElectionId() // Made static and returns value
    {
        return 'ELEC-' . strtoupper(uniqid());
    }

}
