<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    protected $fillable = ['id', 'other_columns', 'reservations_exist'];
    protected $table = "sheets";
    use HasFactory;

    // リレーション定義
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'sheet_id');
    }
}
