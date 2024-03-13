<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    protected $fillable = ['column', 'row']; // これ挿入しないとエラー出る、とChatGPTに教えてもらった
    use HasFactory;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
