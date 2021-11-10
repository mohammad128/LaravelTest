<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['age','address','bio', 'phone', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
