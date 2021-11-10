<?php

namespace App\Models;

use App\Models\Comment\Comment;
use App\Traits\HasTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTag;

    protected $fillable = ['user_id', 'title','content', 'feature_image','status'];

    protected static function boot()
    {
        parent::boot();
        static::forceDeleted(function ($post) {
            $post->comments()->delete();
        });
    }

    public function scopeDraft(Builder $builder) {
        $builder->where('status', 'draft');
    }
    public function scopePublished(Builder $builder) {
        $builder->where('status', 'published');
    }
    public function scopeTrashed( Builder $builder ) {
        $builder->onlyTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->morphMany(Comment::class,'commentable');
    }
}
