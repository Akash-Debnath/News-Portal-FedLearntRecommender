<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'likes',
        'meta_data',
        'author_id',
        'post_id',
    ];

    public function author(){
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    // public function views(){
    //     return $this->belongsToMany(ViewNews::class, 'post_id', 'post_id');
    // }
}
