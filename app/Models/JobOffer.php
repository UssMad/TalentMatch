<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
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

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
