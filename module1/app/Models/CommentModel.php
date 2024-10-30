<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'text',
        'author',
        'date_time',
        'date_publish',
        'id_user',
        'post_id'
    ];
}
