<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likesDislikes extends Model
{
    use HasFactory;

    protected $table = 'likes_dislikes';

    protected $fillable = [
        'user_id', 'post_id', 'like'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
