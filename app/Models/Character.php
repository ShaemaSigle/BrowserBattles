<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function guild(){
        return $this->belongsTo(Guild::class);
    }
    public function encounter(){
        return $this->hasMany(Encounter::class);
    }
}
