<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['date', 'schedule_id', 'sheet_id', 'name', 'email', 'is_canceled'];
    protected $table = "reservations";
    use HasFactory;

    // リレーション定義
    public function sheet()
    {
        return $this->belongsTo(Sheet::class, 'sheet_id');
    }
}
