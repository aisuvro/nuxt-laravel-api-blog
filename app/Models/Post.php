<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['title','body','uuid', 'user_id', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserPosts($scope)
    {
        return $scope->where('user_id', auth()->user()->id);
    }


}
