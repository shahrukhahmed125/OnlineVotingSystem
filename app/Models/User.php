<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'cnic',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }


    public function naConstituency()
    {
        return $this->belongsTo(Assembly::class, 'na_constituency_id');
    }

    public function paConstituency()
    {
        return $this->belongsTo(Assembly::class, 'pa_constituency_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'voter_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public static function generateUserId()
    {
        // Generate a unique user ID, e.g., USR-YYYYMMDD-XXXXX
        $prefix = 'USR-';
        $datePart = now()->format('Ymd'); // Using 'Ymd' for a shorter date part
        $randomPart = strtoupper(Str::random(5)); // 5 random characters

        $userId = $prefix . $datePart . '-' . $randomPart;

        // Ensure uniqueness (optional, but good practice if high collision risk)
        while (static::where('user_id', $userId)->exists()) {
            $randomPart = strtoupper(Str::random(5));
            $userId = $prefix . $datePart . '-' . $randomPart;
        }

        return $userId;
    }

    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
