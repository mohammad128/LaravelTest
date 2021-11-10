<?php

namespace App\Models\Comment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','comment','status','parent_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function commentable() {
        return $this->morphTo();
    }
}
