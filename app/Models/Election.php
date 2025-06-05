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
        'is_active',
        'assembly_id'
    ];

    public function candidates()
    {
        // An Election has an assembly_id.
        // Candidates have a constituency_id (which is an assembly_id).
        // This relationship fetches candidates whose constituency_id matches this election's assembly_id.
        return $this->hasMany(Candidate::class, 'constituency_id', 'assembly_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public static function generateElectionId() // Made static and returns value
    {
        return 'ELEC-' . strtoupper(uniqid());
    }

    public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }
}
