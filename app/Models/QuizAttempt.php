<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\QuizAttempt
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $student_id
 * @property array $answers
 * @property float|null $score
 * @property int $points_earned
 * @property int $total_points
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property bool $is_graded
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Quiz $quiz
 * @property-read \App\Models\User $student
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereIsGraded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt wherePointsEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereTotalPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt completed()

 * 
 * @mixin \Eloquent
 */
class QuizAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quiz_id',
        'student_id',
        'answers',
        'score',
        'points_earned',
        'total_points',
        'started_at',
        'completed_at',
        'is_graded',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answers' => 'array',
        'score' => 'decimal:2',
        'points_earned' => 'integer',
        'total_points' => 'integer',
        'is_graded' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include completed attempts.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * Get the quiz this attempt belongs to.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the student who made this attempt.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}