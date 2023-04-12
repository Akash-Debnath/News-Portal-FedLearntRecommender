<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewNews extends Model
{
    use HasFactory;

    protected $table ='viewnews';
    protected $fillable = [
        'views',
        'meta_data',
        'author_id',
        'post_id',
    ];
}
