<?php

namespace App\Models;

use App\Enums\Recommendation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analysis extends Model
{
    protected $fillable = [
        'candidate_id',
        'job_offer_id',
        'structured_data',
        'matching_score',
        'recommendation',
        'raw_ai_response',
    ];

    protected function casts(): array
    {
        return [
            'structured_data' => 'array',
            'raw_ai_response' => 'array',
            'recommendation' => Recommendation::class,
            'matching_score' => 'integer',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }
}
