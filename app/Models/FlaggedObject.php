<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlaggedObject extends Model
{
    use HasFactory;
    public function guild(){
        return $this->belongsTo(Guild::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function character(){
        return $this->belongsTo(Character::class);
    }
}
