<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Forum
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $course_id
 * @property int $created_by
 * @property bool $is_pinned
 * @property bool $is_locked
 * @property int $posts_count
 * @property \Illuminate\Support\Carbon|null $last_post_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ForumPost> $posts
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Forum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum query()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereLastPostAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum wherePostsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Forum extends Model
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
        'is_pinned',
        'is_locked',
        'posts_count',
        'last_post_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'posts_count' => 'integer',
        'last_post_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the course this forum belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created this forum.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the posts in this forum.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class)->orderBy('created_at');
    }
}