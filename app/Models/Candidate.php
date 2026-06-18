<?php

namespace App\Models;

use App\Jobs\RunAnalysisJob;
use Database\Factories\CandidateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    /** @use HasFactory<CandidateFactory> */
    use HasFactory;

    protected $fillable = [
        'job_offer_id',
        'name',
        'email',
        'phone',
        'cv_text',
        'cv_file_path',
    ];

    protected static function booted(): void
    {
        static::created(function (Candidate $candidate) {
            if ($candidate->job_offer_id && $candidate->cv_text) {
                RunAnalysisJob::dispatch($candidate->id, $candidate->job_offer_id);
            }
        });

        static::updated(function (Candidate $candidate) {
            if ($candidate->job_offer_id && $candidate->cv_text && $candidate->wasChanged('cv_text')) {
                RunAnalysisJob::dispatch($candidate->id, $candidate->job_offer_id);
            }
        });
    }

    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function analyses(): HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
