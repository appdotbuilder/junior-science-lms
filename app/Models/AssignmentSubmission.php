<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AssignmentSubmission
 *
 * @property int $id
 * @property int $assignment_id
 * @property int $student_id
 * @property string|null $content
 * @property string|null $file_path
 * @property string|null $file_name
 * @property string|null $file_type
 * @property int|null $file_size
 * @property float|null $grade
 * @property string|null $feedback
 * @property int|null $graded_by
 * @property \Illuminate\Support\Carbon|null $graded_at
 * @property bool $is_late
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Assignment $assignment
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User|null $grader
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereGradedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereGradedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereIsLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission graded()

 * 
 * @mixin \Eloquent
 */
class AssignmentSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'grade',
        'feedback',
        'graded_by',
        'graded_at',
        'is_late',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'grade' => 'decimal:2',
        'is_late' => 'boolean',
        'graded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include graded submissions.
     */
    public function scopeGraded($query)
    {
        return $query->whereNotNull('grade');
    }

    /**
     * Get the assignment this submission belongs to.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student who made this submission.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the user who graded this submission.
     */
    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}