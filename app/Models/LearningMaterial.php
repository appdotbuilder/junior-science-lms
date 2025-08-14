<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LearningMaterial
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property string|null $content
 * @property string|null $file_path
 * @property string|null $file_type
 * @property int|null $file_size
 * @property int $course_id
 * @property int $uploaded_by
 * @property bool $is_published
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $uploader
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LearningMaterial published()

 * 
 * @mixin \Eloquent
 */
class LearningMaterial extends Model
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
        'type',
        'content',
        'file_path',
        'file_type',
        'file_size',
        'course_id',
        'uploaded_by',
        'is_published',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include published materials.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the course this material belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who uploaded this material.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}