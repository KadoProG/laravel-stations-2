<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['movie_id', 'start_time', 'end_time'];
    protected $table = "schedules";
    use HasFactory;

    public function schedule()
    {
        return $this->belongsTo(Movie::class);
    }

    protected $dates = ['start_time', "end_time"];
}
