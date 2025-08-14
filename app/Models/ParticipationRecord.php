<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ParticipationRecord
 *
 * @property int $id
 * @property int $course_id
 * @property int $student_id
 * @property int $recorded_by
 * @property \Illuminate\Support\Carbon $date
 * @property string $type
 * @property float $points
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User $recorder
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParticipationRecord whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ParticipationRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'recorded_by',
        'date',
        'type',
        'points',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'points' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the course this participation record belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the student this participation record belongs to.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the user who recorded this participation.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}