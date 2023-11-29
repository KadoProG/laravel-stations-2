<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'image_url', 'published_year', 'is_showing', 'description'];
    protected $table = "movies";
    protected $connection = "mysql";
    use HasFactory;
}
