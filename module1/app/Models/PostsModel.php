<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'id',
        'text_post',
        'date_pub',
        'id_user',
        'title'
    ];
}
