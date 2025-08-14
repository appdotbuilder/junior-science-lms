<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Quiz
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $course_id
 * @property int $created_by
 * @property int|null $time_limit
 * @property int $max_attempts
 * @property float $passing_score
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $available_from
 * @property \Illuminate\Support\Carbon|null $available_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuizQuestion> $questions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuizAttempt> $attempts
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereAvailableFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereAvailableUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereMaxAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz wherePassingScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz published()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz available()

 * 
 * @mixin \Eloquent
 */
class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'course_id',
        'created_by',
        'time_limit',
        'max_attempts',
        'passing_score',
        'is_published',
        'available_from',
        'available_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time_limit' => 'integer',
        'max_attempts' => 'integer',
        'passing_score' => 'decimal:2',
        'is_published' => 'boolean',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include published quizzes.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include currently available quizzes.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('available_from')
                  ->orWhere('available_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('available_until')
                  ->orWhere('available_until', '>=', now());
            });
    }

    /**
     * Get the course this quiz belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created this quiz.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the questions for this quiz.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('sort_order');
    }

    /**
     * Get the attempts for this quiz.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}