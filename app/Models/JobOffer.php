<?php

namespace App\Models;

use Database\Factories\JobOfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
{
    /** @use HasFactory<JobOfferFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'required_skills',
        'min_experience',
    ];

    protected $casts = [
        'required_skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function analyses(): HasMany
    {
        return $this->hasMany(Analysis::class);
    }
}
