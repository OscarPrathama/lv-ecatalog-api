<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_author',
        'post_title',
        'post_slug',
        'post_type',
        'excerpt',
        'post_content',
        'post_status',
        'comment_count',
    ];
}
