<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'post_type',
        'created_at',
        'status',
        'body',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->morphMany(images::class, 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public const DRAFT = 0;
    public const ACTIVE = 1;
    public const INACTIVE = 2;

    public const STATUS = [
        self::DRAFT => 'draft',
        self::ACTIVE => 'active',
        self::INACTIVE => 'inactive',
    ];

    public const POST = 'post';
    public const PAGE = 'page';

    protected $casts = [
        'created_at' => 'datetime:d M, Y H:i',
        'updated_at' => 'datetime:d M, Y H:i',
    ];

    protected function scopeActivePost($query)
    {
        return $query->where('status', self::ACTIVE)
            ->where('post_type', self::POST)
            ->where('created_at', '<=', Carbon::now());
    }

    protected function nextPost(): Attribute
    {
        return new Attribute(
            get: fn () => self::ActivePost()
                ->where('created_at', '>', $this->created_at)
                ->orderBy('created_at')
                ->first()
        );
    }

    protected function prevPost(): Attribute
    {
        return new Attribute(
            get: fn () => self::ActivePost()
                ->where('created_at', '<', $this->created_at)
                ->orderBy('created_at', 'desc')
                ->first()
        );
    }
}
