<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function character(){
        return $this->belongsTo(Character::class);
    }
    public function enemy(){
        return $this->belongsTo(Enemy::class);
    }
}
