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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, "movie_id");
    }

    protected $dates = ['start_time', "end_time"];
}
